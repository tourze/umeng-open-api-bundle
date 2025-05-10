<?php

namespace UmengOpenApiBundle\Tests\Command;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UmengOpenApiBundle\Command\GetAppListCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AccountRepository;
use UmengOpenApiBundle\Repository\AppRepository;

/**
 * @runTestsInSeparateProcesses
 */
class GetAppListCommandTest extends TestCase
{
    private GetAppListCommand $command;
    private MockObject $appRepository;
    private MockObject $accountRepository;
    private MockObject $entityManager;
    private MockObject $input;
    private MockObject $output;
    private array $mockedClasses = [];
    private ReflectionMethod $executeMethod;

    protected function setUp(): void
    {
        // 创建所需的模拟对象
        $this->appRepository = $this->createMock(AppRepository::class);
        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->input = $this->createMock(InputInterface::class);
        $this->output = $this->createMock(OutputInterface::class);

        // 创建命令对象
        $this->command = new GetAppListCommand(
            $this->appRepository,
            $this->accountRepository,
            $this->entityManager
        );

        // 使用反射获取受保护的execute方法
        $this->executeMethod = new ReflectionMethod(GetAppListCommand::class, 'execute');
        $this->executeMethod->setAccessible(true);

        // 设置全局类模拟
        $this->setupMockClasses();
    }

    /**
     * 设置全局类模拟，避免实际调用友盟API
     */
    private function setupMockClasses(): void
    {
        // ClientPolicy
        if (!class_exists('\ClientPolicy', false)) {
            eval('
            class ClientPolicy {
                public function __construct(string $apiKey, string $apiSecurity, string $gatewayUrl) {}
            }
            ');
            $this->mockedClasses[] = '\ClientPolicy';
        }
        
        // RequestPolicy
        if (!class_exists('\RequestPolicy', false)) {
            eval('
            class RequestPolicy {
                public $httpMethod;
                public $needAuthorization;
                public $requestSendTimestamp;
                public $useHttps;
                public $useSignture;
                public $accessPrivateApi;
            }
            ');
            $this->mockedClasses[] = '\RequestPolicy';
        }
        
        // UmengUappGetAppListParam
        if (!class_exists('\UmengUappGetAppListParam', false)) {
            eval('
            class UmengUappGetAppListParam {
                public function setPage($page) {}
                public function setPerPage($perPage) {}
                public function setAccessToken($token) {}
            }
            ');
            $this->mockedClasses[] = '\UmengUappGetAppListParam';
        }
        
        // APIRequest
        if (!class_exists('\APIRequest', false)) {
            eval('
            class APIRequest {
                public $apiId;
                public $requestEntity;
            }
            ');
            $this->mockedClasses[] = '\APIRequest';
        }
        
        // APIId
        if (!class_exists('\APIId', false)) {
            eval('
            class APIId {
                public function __construct($namespace, $name, $version) {}
            }
            ');
            $this->mockedClasses[] = '\APIId';
        }
        
        // UmengUappAppInfoData
        if (!class_exists('\UmengUappAppInfoData', false)) {
            eval('
            class UmengUappAppInfoData {
                private $appkey;
                private $name;
                private $platform;
                private $popular;
                private $useGameSdk;
                private $createdAt;
                
                public function __construct($appkey = "", $name = "", $platform = "", $popular = false, $useGameSdk = false, $createdAt = "") {
                    $this->appkey = $appkey;
                    $this->name = $name;
                    $this->platform = $platform;
                    $this->popular = $popular;
                    $this->useGameSdk = $useGameSdk;
                    $this->createdAt = $createdAt;
                }
                
                public function getAppkey() { return $this->appkey; }
                public function getName() { return $this->name; }
                public function getPlatform() { return $this->platform; }
                public function getPopular() { return $this->popular; }
                public function getUseGameSdk() { return $this->useGameSdk; }
                public function getCreatedAt() { return $this->createdAt; }
            }
            ');
            $this->mockedClasses[] = '\UmengUappAppInfoData';
        }
        
        // UmengUappGetAppListResult
        if (!class_exists('\UmengUappGetAppListResult', false)) {
            eval('
            class UmengUappGetAppListResult {
                private $appInfos = [];
                
                public function setAppInfos($appInfos) {
                    $this->appInfos = $appInfos;
                }
                
                public function getAppInfos() {
                    return $this->appInfos;
                }
            }
            ');
            $this->mockedClasses[] = '\UmengUappGetAppListResult';
        }
        
        // SyncAPIClient
        if (!class_exists('\SyncAPIClient', false)) {
            eval('
            class SyncAPIClient {
                public function __construct($clientPolicy) {}
                
                public function send($request, &$result, $reqPolicy) {
                    if (is_array($GLOBALS["mock_api_response"]) && isset($GLOBALS["mock_api_response"]["appInfos"])) {
                        $result->setAppInfos($GLOBALS["mock_api_response"]["appInfos"]);
                    }
                }
            }
            ');
            $this->mockedClasses[] = '\SyncAPIClient';
        }
    }
    
    /**
     * 测试当没有有效账户时的执行情况
     */
    public function testExecuteWithNoAccounts(): void
    {
        // 设置 AccountRepository 模拟对象返回空数组
        $this->accountRepository->expects($this->once())
            ->method('findBy')
            ->with(['valid' => true])
            ->willReturn([]);

        // 确保 EntityManager 的 persist 和 flush 方法不会被调用
        $this->entityManager->expects($this->never())
            ->method('persist');
        $this->entityManager->expects($this->never())
            ->method('flush');

        // 使用反射调用受保护的execute方法
        $result = $this->executeMethod->invoke($this->command, $this->input, $this->output);

        // 验证返回成功状态
        $this->assertEquals(Command::SUCCESS, $result);
    }

    /**
     * 测试当有有效账户但API返回空结果时的执行情况
     */
    public function testExecuteWithAccountButEmptyApiResult(): void
    {
        // 创建账户模拟对象
        $account = new Account();
        $account->setApiKey('test_api_key');
        $account->setApiSecurity('test_api_security');

        // 设置 AccountRepository 模拟对象返回一个账户
        $this->accountRepository->expects($this->once())
            ->method('findBy')
            ->with(['valid' => true])
            ->willReturn([$account]);

        // 模拟空的API响应
        $GLOBALS['mock_api_response'] = ['appInfos' => []];

        // 确保 EntityManager 的 persist 和 flush 方法不会被调用
        $this->entityManager->expects($this->never())
            ->method('persist');
        $this->entityManager->expects($this->never())
            ->method('flush');

        // 使用反射调用受保护的execute方法
        $result = $this->executeMethod->invoke($this->command, $this->input, $this->output);

        // 验证返回成功状态
        $this->assertEquals(Command::SUCCESS, $result);
    }

    /**
     * 测试当API返回有效App信息时的执行情况
     */
    public function testExecuteWithValidAppInfo(): void
    {
        // 创建账户模拟对象
        $account = new Account();
        $account->setApiKey('test_api_key');
        $account->setApiSecurity('test_api_security');

        // 设置 AccountRepository 模拟对象返回一个账户
        $this->accountRepository->expects($this->once())
            ->method('findBy')
            ->with(['valid' => true])
            ->willReturn([$account]);

        // 创建App信息模拟对象
        $appInfo = new \UmengUappAppInfoData(
            'test_app_key',
            'Test App',
            'android',
            true,
            false,
            '2023-01-01 00:00:00'
        );

        // 模拟API响应
        $GLOBALS['mock_api_response'] = ['appInfos' => [$appInfo]];

        // 设置 AppRepository 模拟对象的行为
        $this->appRepository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'account' => $account,
                'appKey' => 'test_app_key'
            ])
            ->willReturn(null); // 假设App不存在，需要创建新的

        // 确保 EntityManager 的 persist 和 flush 方法会被调用
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($app) {
                return $app instanceof App 
                    && $app->getAppKey() === 'test_app_key'
                    && $app->getName() === 'Test App'
                    && $app->getPlatform() === 'android'
                    && $app->isPopular() === true
                    && $app->isUseGameSdk() === false;
            }));
        $this->entityManager->expects($this->once())->method('flush');

        // 使用反射调用受保护的execute方法
        $result = $this->executeMethod->invoke($this->command, $this->input, $this->output);

        // 验证返回成功状态
        $this->assertEquals(Command::SUCCESS, $result);
    }

    /**
     * 测试当App已存在时的更新行为
     */
    public function testExecuteUpdateExistingApp(): void
    {
        // 创建账户模拟对象
        $account = new Account();
        $account->setApiKey('test_api_key');
        $account->setApiSecurity('test_api_security');

        // 创建已存在的App对象
        $existingApp = new App();
        $existingApp->setAccount($account);
        $existingApp->setAppKey('test_app_key');
        $existingApp->setName('Old App Name');
        $existingApp->setPlatform('ios');
        $existingApp->setPopular(false);
        $existingApp->setUseGameSdk(true);

        // 设置 AccountRepository 模拟对象返回一个账户
        $this->accountRepository->expects($this->once())
            ->method('findBy')
            ->with(['valid' => true])
            ->willReturn([$account]);

        // 创建App信息模拟对象
        $appInfo = new \UmengUappAppInfoData(
            'test_app_key',
            'New App Name',
            'android',
            true,
            false,
            '2023-01-01 00:00:00'
        );

        // 模拟API响应
        $GLOBALS['mock_api_response'] = ['appInfos' => [$appInfo]];

        // 设置 AppRepository 模拟对象的行为，返回已存在的App
        $this->appRepository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'account' => $account,
                'appKey' => 'test_app_key'
            ])
            ->willReturn($existingApp);

        // 确保 EntityManager 的 persist 和 flush 方法会被调用
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($app) {
                return $app instanceof App 
                    && $app->getAppKey() === 'test_app_key'
                    && $app->getName() === 'New App Name'
                    && $app->getPlatform() === 'android'
                    && $app->isPopular() === true
                    && $app->isUseGameSdk() === false;
            }));
        $this->entityManager->expects($this->once())->method('flush');

        // 使用反射调用受保护的execute方法
        $result = $this->executeMethod->invoke($this->command, $this->input, $this->output);

        // 验证返回成功状态
        $this->assertEquals(Command::SUCCESS, $result);
        
        // 验证App的属性已更新
        $this->assertEquals('New App Name', $existingApp->getName());
        $this->assertEquals('android', $existingApp->getPlatform());
        $this->assertTrue($existingApp->isPopular());
        $this->assertFalse($existingApp->isUseGameSdk());
    }

    /**
     * 清理全局模拟变量
     */
    protected function tearDown(): void
    {
        // 清理全局变量
        if (isset($GLOBALS['mock_api_response'])) {
            unset($GLOBALS['mock_api_response']);
        }
    }
} 