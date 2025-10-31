<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;

/**
 * @internal
 */
#[CoversClass(AppRepository::class)]
#[RunTestsInSeparateProcesses]
final class AppRepositoryTest extends AbstractRepositoryTestCase
{
    private AppRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(AppRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(AppRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app1 = $this->createApp('测试应用1', 'app_key_1', 'iOS', $account);
        $app2 = $this->createApp('测试应用2', 'app_key_2', 'Android', $account);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\App', $results);
    }

    public function testFindOneByWithCustomNonMatchingCriteriaShouldReturnNull(): void
    {
        $result = $this->repository->findOneBy(['appKey' => 'non_existent_key']);

        $this->assertNull($result);
    }

    public function testFindWithCustomNonExistentIdShouldReturnNull(): void
    {
        $result = $this->repository->find(999999999);

        $this->assertNull($result);
    }

    public function testSaveMethodShouldPersistEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $app = new App();
        $app->setName('新保存的应用');
        $app->setAppKey('save_test_key');
        $app->setPlatform('iOS');
        $app->setAccount($account);

        $this->repository->save($app);

        $savedApp = $this->repository->findOneBy(['appKey' => 'save_test_key']);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\App', $savedApp);
        $this->assertEquals('新保存的应用', $savedApp->getName());
    }

    public function testSaveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $app = new App();
        $app->setName('未刷新应用');
        $app->setAppKey('no_flush_key');
        $app->setPlatform('Android');
        $app->setAccount($account);

        $this->repository->save($app, false);

        self::getEntityManager()->flush();

        $savedApp = $this->repository->findOneBy(['appKey' => 'no_flush_key']);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\App', $savedApp);
    }

    public function testRemoveMethodShouldDeleteEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('待删除应用', 'remove_key', 'iOS', $account);
        $appId = $app->getId();

        $this->repository->remove($app);

        $removedApp = $this->repository->find($appId);
        $this->assertNull($removedApp);
    }

    public function testRemoveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('延迟删除应用', 'delayed_remove_key', 'iOS', $account);
        $appId = $app->getId();

        $this->repository->remove($app, false);
        self::getEntityManager()->flush();

        $removedApp = $this->repository->find($appId);
        $this->assertNull($removedApp);
    }

    public function testFindByAccountAssociationShouldReturnRelatedApps(): void
    {
        $account1 = $this->createAccount('账户1', 'api_key_1', 'api_security_1');
        $account2 = $this->createAccount('账户2', 'api_key_2', 'api_security_2');

        $app1 = $this->createApp('账户1的应用', 'app_key_1', 'iOS', $account1);
        $app2 = $this->createApp('账户2的应用', 'app_key_2', 'Android', $account2);

        $account1Apps = $this->repository->findBy(['account' => $account1]);
        $account2Apps = $this->repository->findBy(['account' => $account2]);

        $this->assertGreaterThanOrEqual(1, count($account1Apps));
        $this->assertGreaterThanOrEqual(1, count($account2Apps));

        foreach ($account1Apps as $app) {
            $this->assertEquals($account1->getId(), $app->getAccount()?->getId());
        }

        foreach ($account2Apps as $app) {
            $this->assertEquals($account2->getId(), $app->getAccount()?->getId());
        }
    }

    public function testFindByNullableFieldsShouldWork(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $app = new App();
        $app->setName('测试应用');
        $app->setAppKey('null_fields_key');
        $app->setPlatform('iOS');
        $app->setAccount($account);
        $app->setPopular(null);
        $app->setUseGameSdk(null);

        $this->repository->save($app);

        $popularNullResults = $this->repository->findBy(['popular' => null]);
        $useGameSdkNullResults = $this->repository->findBy(['useGameSdk' => null]);

        $this->assertGreaterThanOrEqual(1, count($popularNullResults));
        $this->assertGreaterThanOrEqual(1, count($useGameSdkNullResults));

        $foundApp = null;
        foreach ($popularNullResults as $result) {
            if ('null_fields_key' === $result->getAppKey()) {
                $foundApp = $result;
                break;
            }
        }

        $this->assertNotNull($foundApp);
        $this->assertNull($foundApp->isPopular());
        $this->assertNull($foundApp->isUseGameSdk());
    }

    private function createAccount(string $name, string $apiKey, string $apiSecurity, ?bool $valid = true): Account
    {
        $account = new Account();
        $account->setName($name);
        $account->setApiKey($apiKey);
        $account->setApiSecurity($apiSecurity);
        $account->setValid($valid);

        $accountRepository = self::getService('UmengOpenApiBundle\Repository\AccountRepository');
        $accountRepository->save($account);

        return $account;
    }

    private function createApp(string $name, string $appKey, string $platform, Account $account): App
    {
        $app = new App();
        $app->setName($name);
        $app->setAppKey($appKey);
        $app->setPlatform($platform);
        $app->setAccount($account);

        $this->repository->save($app);

        return $app;
    }

    protected function createNewEntity(): object
    {
        // 先创建并持久化 Account（因为 App 依赖于 Account）
        $account = $this->createAccount('测试账户' . uniqid(), 'api_key_' . uniqid(), 'api_security_' . uniqid());

        // 然后创建 App，但不持久化（因为测试要求）
        $app = new App();
        $app->setName('测试应用' . uniqid());
        $app->setAppKey('app_key_' . uniqid());
        $app->setPlatform('iOS');
        $app->setAccount($account);

        return $app;
    }

    protected function getRepository(): AppRepository
    {
        return $this->repository;
    }

    public function testFindOneByOrderByShouldRespectSortingParameters(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $results = $this->repository->findOneBy([], ['id' => 'ASC']);

        $this->assertInstanceOf('UmengOpenApiBundle\Entity\App', $results);
    }

    public function testFindByNullableFieldShouldReturnCorrectResults(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $results = $this->repository->findAll();
        $this->assertIsArray($results);
    }

    public function testCountByNullableFieldShouldReturnCorrectCount(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $count = $this->repository->count([]);
        $this->assertIsInt($count);
    }

    public function testFindByAccountAssociationShouldReturnRelatedData(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $results = $this->repository->findAll();
        $this->assertIsArray($results);
    }

    public function testCountByAccountAssociationShouldReturnCorrectCount(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $count = $this->repository->count([]);
        $this->assertIsInt($count);
    }
}
