<?php

namespace UmengOpenApiBundle\Command;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AccountRepository;
use UmengOpenApiBundle\Repository\AppRepository;

#[AsCronTask('*/10 * * * *')]
#[AsCommand(name: 'umeng-open-api:get-app-list', description: '获取App列表')]
class GetAppListCommand extends Command
{
    
    public const NAME = 'umeng-open-api:get-app-list';
public function __construct(
        private readonly AppRepository $appRepository,
        private readonly AccountRepository $accountRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->accountRepository->findBy(['valid' => true]) as $account) {
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

            // --------------------------构造参数----------------------------------

            $param = new \UmengUappGetAppListParam();
            $param->setPage(1);
            $param->setPerPage(100); // 只同步一页数据
            $param->setAccessToken('');

            // --------------------------构造请求----------------------------------

            $request = new \APIRequest();
            $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getAppList', 1);
            $request->apiId = $apiId;
            $request->requestEntity = $param;

            // --------------------------构造结果----------------------------------

            $result = new \UmengUappGetAppListResult();
            $syncAPIClient->send($request, $result, $reqPolicy);
            foreach ($result->getAppInfos() as $appInfo) {
                /** @var \UmengUappAppInfoData $appInfo */
                $app = $this->appRepository->findOneBy([
                    'account' => $account,
                    'appKey' => $appInfo->getAppkey(),
                ]);
                if (!$app) {
                    $app = new App();
                    $app->setAccount($account);
                    $app->setAppKey($appInfo->getAppkey());
                }
                $app->setName($appInfo->getName());
                $app->setPlatform($appInfo->getPlatform());
                $app->setPopular((bool) $appInfo->getPopular());
                $app->setUseGameSdk((bool) $appInfo->getUseGameSdk());
                $app->setCreateTime(Carbon::parse($appInfo->getCreatedAt()));
                $this->entityManager->persist($app);
                $this->entityManager->flush();
            }
        }

        return Command::SUCCESS;
    }
}
