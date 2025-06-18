<?php

namespace UmengOpenApiBundle\Command;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\ThirtyDayActiveUsers;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\ThirtyDayActiveUsersRepository;

#[AsCronTask('*/30 * * * *')]
#[AsCommand(name: 'umeng-open-api:get-thirty-day-active-users', description: '获取App活跃用户数(30天)')]
class GetThirtyDayActiveUsersCommand extends Command
{
    
    public const NAME = 'umeng-open-api:get-thirty-day-active-users';
public function __construct(
        private readonly AppRepository $appRepository,
        private readonly ThirtyDayActiveUsersRepository $thirtyDaysActiveUsersRepository,
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

            $param = new \UmengUappGetActiveUsersParam();
            $param->setAppkey($app->getAppKey());
            $param->setStartDate($startDate->format('Y-m-d'));
            $param->setEndDate($endDate->format('Y-m-d'));
            $param->setPeriodType('30day');

            $request = new \APIRequest();
            $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getActiveUsers', 1);
            $request->apiId = $apiId;
            $request->requestEntity = $param;

            $result = new \UmengUappGetActiveUsersResult();
            $syncAPIClient->send($request, $result, $reqPolicy);

            foreach ($result->getActiveUserInfo() as $item) {
                /** @var \UmengUappCountData $item */
                $date = Carbon::parse($item->getDate())->startOfDay();

                $newUsers = $this->thirtyDaysActiveUsersRepository->findOneBy([
                    'app' => $app,
                    'date' => $date,
                ]);
                if (!$newUsers) {
                    $newUsers = new ThirtyDayActiveUsers();
                    $newUsers->setApp($app);
                    $newUsers->setDate($date);
                }
                $newUsers->setValue($item->getValue());
                $this->entityManager->persist($newUsers);
                $this->entityManager->flush();
            }
        }

        return Command::SUCCESS;
    }
}
