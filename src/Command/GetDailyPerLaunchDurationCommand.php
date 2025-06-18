<?php

namespace UmengOpenApiBundle\Command;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyPerLaunchDurationRepository;

#[AsCronTask('*/35 * * * *')]
#[AsCommand(name: 'umeng-open-api:get-daily-per-launch-duration', description: '获取App使用时长-daily_per_launch')]
class GetDailyPerLaunchDurationCommand extends Command
{
    
    public const NAME = 'umeng-open-api:get-daily-per-launch-duration';
public function __construct(
        private readonly DailyPerLaunchDurationRepository $durationRepository,
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
        $endDate = $input->getArgument('endDate')
            ? Carbon::parse($input->getArgument('endDate'))->startOfDay()
            : Carbon::today();
        $startDate = $input->getArgument('startDate')
            ? Carbon::parse($input->getArgument('startDate'))->startOfDay()
            : $endDate->clone()->subDays(30);
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
                $param->setStatType('daily_per_launch');
                $param->setVersion('');
                $param->setChannel('');

                // --------------------------构造请求----------------------------------

                $request = new \APIRequest();
                $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getDurations', 1);
                $request->apiId = $apiId;
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
                    if (!$item) {
                        $item = new DailyPerLaunchDuration();
                        $item->setApp($app);
                        $item->setDate($date);
                        $item->setName($durationInfo->getName());
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
