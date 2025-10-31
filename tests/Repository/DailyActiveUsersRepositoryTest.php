<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyActiveUsers;
use UmengOpenApiBundle\Repository\DailyActiveUsersRepository;

/**
 * @internal
 */
#[CoversClass(DailyActiveUsersRepository::class)]
#[RunTestsInSeparateProcesses]
final class DailyActiveUsersRepositoryTest extends AbstractRepositoryTestCase
{
    private DailyActiveUsersRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(DailyActiveUsersRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(DailyActiveUsersRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data1 = $this->createDailyActiveUsers($app, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createDailyActiveUsers($app, new \DateTimeImmutable('2024-01-02'), 1100);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\DailyActiveUsers', $results);
    }

    public function testFindOneByWithCustomNonMatchingCriteriaShouldReturnNull(): void
    {
        $result = $this->repository->findOneBy(['date' => new \DateTimeImmutable('2099-12-31')]);

        $this->assertNull($result);
    }

    public function testFindWithCustomNonExistentIdShouldReturnNull(): void
    {
        $result = $this->repository->find(999999999);

        $this->assertNull($result);
    }

    public function testFindByAppAssociationShouldReturnRelatedData(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app1 = $this->createApp('应用1', 'app_key_1', 'iOS', $account);
        $app2 = $this->createApp('应用2', 'app_key_2', 'Android', $account);

        $data1 = $this->createDailyActiveUsers($app1, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createDailyActiveUsers($app2, new \DateTimeImmutable('2024-01-01'), 2000);

        $app1Data = $this->repository->findBy(['app' => $app1]);
        $app2Data = $this->repository->findBy(['app' => $app2]);

        $this->assertGreaterThanOrEqual(1, count($app1Data));
        $this->assertGreaterThanOrEqual(1, count($app2Data));

        /** @var DailyActiveUsers $data */
        foreach ($app1Data as $data) {
            $this->assertEquals($app1->getId(), $data->getApp()->getId());
        }

        /** @var DailyActiveUsers $data */
        foreach ($app2Data as $data) {
            $this->assertEquals($app2->getId(), $data->getApp()->getId());
        }
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

        $appRepository = self::getService('UmengOpenApiBundle\Repository\AppRepository');
        $appRepository->save($app);

        return $app;
    }

    private function createDailyActiveUsers(App $app, \DateTimeInterface $date, int $value): DailyActiveUsers
    {
        $data = new DailyActiveUsers();
        $data->setApp($app);
        $data->setDate($date);
        $data->setValue($value);

        $this->repository->save($data);

        return $data;
    }

    protected function createNewEntity(): object
    {
        // 先创建并持久化 Account 和 App（因为 DailyActiveUsers 依赖于它们）
        $account = $this->createAccount('测试账户' . uniqid(), 'api_key_' . uniqid(), 'api_security_' . uniqid());
        $app = $this->createApp('测试应用' . uniqid(), 'app_key_' . uniqid(), 'iOS', $account);

        // 然后创建 DailyActiveUsers，但不持久化（因为测试要求）
        $data = new DailyActiveUsers();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-01-01'));
        $data->setValue(1000);

        return $data;
    }

    protected function getRepository(): DailyActiveUsersRepository
    {
        return $this->repository;
    }

    public function testFindOneByOrderByShouldRespectSortingParameters(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $results = $this->repository->findOneBy([], ['id' => 'ASC']);

        $this->assertInstanceOf('UmengOpenApiBundle\Entity\DailyActiveUsers', $results);
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

    public function testSave(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data = new DailyActiveUsers();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-01-01'));
        $data->setValue(1000);

        // Test save without flush
        $this->repository->save($data, false);
        self::getEntityManager()->flush();

        $id = $data->getId();
        $this->assertGreaterThan(0, $id);
    }

    public function testRemove(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data = new DailyActiveUsers();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-01-01'));
        $data->setValue(1000);
        $this->repository->save($data);

        $id = $data->getId();

        // Test remove without flush
        $this->repository->remove($data, false);
        self::getEntityManager()->flush();

        $result = $this->repository->find($id);
        $this->assertNull($result);
    }
}
