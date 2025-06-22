<?php

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\WeeklyLaunches;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\WeeklyLaunchesRepository;

#[AsCronTask('*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App启动次数(周)')]
class GetWeeklyLaunchesCommand extends Command
{
    
    public const NAME = 'umeng-open-api:get-weekly-launches';
public function __construct(
        private readonly AppRepository $appRepository,
        private readonly WeeklyLaunchesRepository $launchesRepository,
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
            : $endDate->subDays(180); // 默认最近半年喔

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

            $param = new \UmengUappGetLaunchesParam();
            $param->setAppkey($app->getAppKey());
            $param->setStartDate($startDate->format('Y-m-d'));
            $param->setEndDate($endDate->format('Y-m-d'));
            $param->setPeriodType('weekly');

            $request = new \APIRequest();
            $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getLaunches', 1);
            $request->apiId = $apiId;
            /** @phpstan-ignore-next-line */
            $request->requestEntity = $param;

            $result = new \UmengUappGetLaunchesResult();
            $syncAPIClient->send($request, $result, $reqPolicy);

            foreach ($result->getLaunchInfo() as $item) {
                /** @var \UmengUappCountData $item */
                $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();

                $newUsers = $this->launchesRepository->findOneBy([
                    'app' => $app,
                    'date' => $date,
                ]);
                if ($newUsers === null) {
                    $newUsers = new WeeklyLaunches();
                    $newUsers->setApp($app);
                    $newUsers->setDate($date);
                }
                $newUsers->setValue((int) $item->getValue());
                $this->entityManager->persist($newUsers);
                $this->entityManager->flush();
            }
        }

        return Command::SUCCESS;
    }
}
