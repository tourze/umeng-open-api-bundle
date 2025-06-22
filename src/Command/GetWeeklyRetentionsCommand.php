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
use UmengOpenApiBundle\Entity\WeeklyRetentions;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\WeeklyRetentionsRepository;

#[AsCronTask('*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App新增用户留存率(周)')]
class GetWeeklyRetentionsCommand extends Command
{
    
    public const NAME = 'umeng-open-api:get-weekly-retentions';
public function __construct(
        private readonly AppRepository $appRepository,
        private readonly WeeklyRetentionsRepository $retentionsRepository,
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

            $param = new \UmengUappGetRetentionsParam();
            $param->setAppkey($app->getAppKey());
            $param->setStartDate($startDate->format('Y-m-d'));
            $param->setEndDate($endDate->format('Y-m-d'));
            $param->setPeriodType('weekly');

            $request = new \APIRequest();
            $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getRetentions', 1);
            $request->apiId = $apiId;
            /** @phpstan-ignore-next-line */
            $request->requestEntity = $param;

            $result = new \UmengUappGetRetentionsResult();
            $syncAPIClient->send($request, $result, $reqPolicy);

            foreach ($result->getRetentionInfo() as $item) {
                /** @var \UmengUappRetentionInfo $item */
                $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();

                $dbItem = $this->retentionsRepository->findOneBy([
                    'app' => $app,
                    'date' => $date,
                ]);
                if ($dbItem === null) {
                    $dbItem = new WeeklyRetentions();
                    $dbItem->setApp($app);
                    $dbItem->setDate($date);
                }
                $dbItem->setTotalInstallUser((int) $item->getTotalInstallUser());
                $dbItem->setRetentionRate((float) $item->getRetentionRate());
                $this->entityManager->persist($dbItem);
                $this->entityManager->flush();
            }
        }

        return Command::SUCCESS;
    }
}
