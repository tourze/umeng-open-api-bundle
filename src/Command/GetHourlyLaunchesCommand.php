<?php

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\HourlyLaunches;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\HourlyLaunchesRepository;

#[AsCronTask(expression: '15 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App启动次数(小时)')]
class GetHourlyLaunchesCommand extends Command
{
    
    public const NAME = 'umeng-open-api:get-hourly-launches';
public function __construct(
        private readonly AppRepository $appRepository,
        private readonly HourlyLaunchesRepository $launchesRepository,
        #[Autowire(service: 'umeng-open-api.property-accessor')] private readonly PropertyAccessor $propertyAccessor,
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
            $param->setPeriodType('hourly');

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

                $dbItem = $this->launchesRepository->findOneBy([
                    'app' => $app,
                    'date' => $date,
                ]);
                if ($dbItem === null) {
                    $dbItem = new HourlyLaunches();
                    $dbItem->setApp($app);
                    $dbItem->setDate($date);
                }
                $hourValues = $item->getHourValue();
                if (is_array($hourValues)) {
                    foreach ($hourValues as $key => $value) {
                        $this->propertyAccessor->setValue($dbItem, "hour{$key}", $value);
                    }
                }
                $this->entityManager->persist($dbItem);
                $this->entityManager->flush();
            }
        }

        return Command::SUCCESS;
    }
}
