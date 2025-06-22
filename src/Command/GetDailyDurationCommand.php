<?php

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\DailyDuration;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyDurationRepository;

#[AsCronTask('*/35 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App使用时长-daily')]
class GetDailyDurationCommand extends Command
{
    
    public const NAME = 'umeng-open-api:get-daily-duration';
public function __construct(
        private readonly DailyDurationRepository $durationRepository,
        private readonly AppRepository $appRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('startDate', InputArgument::OPTIONAL)
            ->addArgument('endDate', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $endDate = $input->getArgument('endDate') !== null ? CarbonImmutable::parse($input->getArgument('endDate'))->startOfDay()
            : CarbonImmutable::today();
        $startDate = $input->getArgument('startDate') !== null ? CarbonImmutable::parse($input->getArgument('startDate'))->startOfDay()
            : $endDate->subDays(30);
        $dateList = CarbonPeriod::between($startDate, $endDate)->toArray();

        foreach ($this->appRepository->findAll() as $app) {
            $account = $app->getAccount();

            // 请替换第一个参数apiKey和第二个参数apiSecurity
            $clientPolicy = new \ClientPolicy($account->getApiKey(), $account->getApiSecurity(), 'gateway.open.umeng.com');
            $syncAPIClient = new \SyncAPIClient($clientPolicy);

            $reqPolicy = new \RequestPolicy();
            $reqPolicy->httpMethod = 'POST';
            $reqPolicy->needAuthorization = false;
            $reqPolicy->requestSendTimestamp = false;
            // 测试环境只支持http
            // $reqPolicy->useHttps = false;
            $reqPolicy->useHttps = true;
            $reqPolicy->useSignture = true;
            $reqPolicy->accessPrivateApi = false;

            foreach ($dateList as $date) {
                // --------------------------构造参数----------------------------------
                $param = new \UmengUappGetDurationsParam();
                $param->setAppkey($app->getAppKey());
                $param->setDate($date->format('Y-m-d'));
                $param->setStatType('daily');
                $param->setVersion('');
                $param->setChannel('');

                // --------------------------构造请求----------------------------------

                $request = new \APIRequest();
                $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getDurations', 1);
                $request->apiId = $apiId;
                /** @phpstan-ignore-next-line */
                $request->requestEntity = $param;

                // --------------------------构造结果----------------------------------

                $result = new \UmengUappGetDurationsResult();
                $syncAPIClient->send($request, $result, $reqPolicy);

                foreach ($result->getDurationInfos() as $durationInfo) {
                    $item = $this->durationRepository->findOneBy([
                        'app' => $app,
                        'date' => $date,
                        'name' => $durationInfo->getName(),
                    ]);
                    if ($item === null) {
                        $item = new DailyDuration();
                        $item->setApp($app);
                        $item->setDate($date);
                        $item->setName((string) $durationInfo->getName());
                    }
                    $item->setValue((int) $durationInfo->getValue());
                    $item->setPercent((float) $durationInfo->getPercent());
                    $this->entityManager->persist($item);
                    $this->entityManager->flush();
                }
            }
        }

        return Command::SUCCESS;
    }
}
