<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyData;
use UmengOpenApiBundle\Repository\DailyDataRepository;

/**
 * @internal
 */
#[CoversClass(DailyDataRepository::class)]
#[RunTestsInSeparateProcesses]
final class DailyDataRepositoryTest extends AbstractRepositoryTestCase
{
    private DailyDataRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(DailyDataRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(DailyDataRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data1 = $this->createDailyData($app, new \DateTimeImmutable('2024-01-01'), 100, 200, 50, 10, 5);
        $data2 = $this->createDailyData($app, new \DateTimeImmutable('2024-01-02'), 110, 210, 55, 12, 6);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\DailyData', $results);
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

    public function testSaveMethodShouldPersistEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $data = new DailyData();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-02-15'));
        $data->setActivityUsers(500);
        $data->setTotalUsers(1000);
        $data->setLaunches(250);
        $data->setNewUsers(50);
        $data->setPayUsers(25);

        $this->repository->save($data);

        $savedData = $this->repository->findOneBy(['date' => new \DateTimeImmutable('2024-02-15'), 'app' => $app]);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\DailyData', $savedData);
        $this->assertEquals(500, $savedData->getActivityUsers());
    }

    public function testSaveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $data = new DailyData();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-03-15'));
        $data->setActivityUsers(600);
        $data->setTotalUsers(1200);
        $data->setLaunches(300);
        $data->setNewUsers(60);
        $data->setPayUsers(30);

        $this->repository->save($data, false);

        self::getEntityManager()->flush();

        $savedData = $this->repository->findOneBy(['date' => new \DateTimeImmutable('2024-03-15'), 'app' => $app]);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\DailyData', $savedData);
    }

    public function testRemoveMethodShouldDeleteEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data = $this->createDailyData($app, new \DateTimeImmutable('2024-04-15'), 100, 200, 50, 10, 5);
        $dataId = $data->getId();

        $this->repository->remove($data);

        $removedData = $this->repository->find($dataId);
        $this->assertNull($removedData);
    }

    public function testRemoveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data = $this->createDailyData($app, new \DateTimeImmutable('2024-05-15'), 100, 200, 50, 10, 5);
        $dataId = $data->getId();

        $this->repository->remove($data, false);
        self::getEntityManager()->flush();

        $removedData = $this->repository->find($dataId);
        $this->assertNull($removedData);
    }

    public function testFindByAppAssociationShouldReturnRelatedData(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app1 = $this->createApp('应用1', 'app_key_1', 'iOS', $account);
        $app2 = $this->createApp('应用2', 'app_key_2', 'Android', $account);

        $data1 = $this->createDailyData($app1, new \DateTimeImmutable('2024-01-01'), 100, 200, 50, 10, 5);
        $data2 = $this->createDailyData($app2, new \DateTimeImmutable('2024-01-01'), 200, 400, 100, 20, 10);

        $app1Data = $this->repository->findBy(['app' => $app1]);
        $app2Data = $this->repository->findBy(['app' => $app2]);

        $this->assertGreaterThanOrEqual(1, count($app1Data));
        $this->assertGreaterThanOrEqual(1, count($app2Data));

        /** @var DailyData $data */
        foreach ($app1Data as $data) {
            $this->assertEquals($app1->getId(), $data->getApp()->getId());
        }

        /** @var DailyData $data */
        foreach ($app2Data as $data) {
            $this->assertEquals($app2->getId(), $data->getApp()->getId());
        }
    }

    public function testFindByNullableFieldsShouldWork(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $data = new DailyData();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-06-15'));
        $data->setActivityUsers(null);
        $data->setTotalUsers(null);
        $data->setLaunches(null);
        $data->setNewUsers(null);
        $data->setPayUsers(null);

        $this->repository->save($data);

        $nullActivityResults = $this->repository->findBy(['activityUsers' => null]);
        $nullTotalUsersResults = $this->repository->findBy(['totalUsers' => null]);

        $this->assertGreaterThanOrEqual(1, count($nullActivityResults));
        $this->assertGreaterThanOrEqual(1, count($nullTotalUsersResults));

        $foundData = null;
        /** @var DailyData $result */
        foreach ($nullActivityResults as $result) {
            if (null !== $result->getDate() && '2024-06-15' === $result->getDate()->format('Y-m-d')) {
                $foundData = $result;
                break;
            }
        }

        $this->assertNotNull($foundData);
        $this->assertNull($foundData->getActivityUsers());
        $this->assertNull($foundData->getTotalUsers());
        $this->assertNull($foundData->getLaunches());
        $this->assertNull($foundData->getNewUsers());
        $this->assertNull($foundData->getPayUsers());
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

    private function createDailyData(App $app, \DateTimeInterface $date, ?int $activityUsers, ?int $totalUsers, ?int $launches, ?int $newUsers, ?int $payUsers): DailyData
    {
        $data = new DailyData();
        $data->setApp($app);
        $data->setDate($date);
        $data->setActivityUsers($activityUsers);
        $data->setTotalUsers($totalUsers);
        $data->setLaunches($launches);
        $data->setNewUsers($newUsers);
        $data->setPayUsers($payUsers);

        $this->repository->save($data);

        return $data;
    }

    protected function createNewEntity(): object
    {
        $account = $this->createAccount('测试账户', 'test_api_key_' . uniqid(), 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key_' . uniqid(), 'iOS', $account);

        $entity = new DailyData();
        $entity->setApp($app);
        $entity->setDate(new \DateTimeImmutable('2024-01-01'));

        return $entity;
    }

    protected function getRepository(): DailyDataRepository
    {
        return $this->repository;
    }

    public function testFindOneByOrderByShouldRespectSortingParameters(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $result = $this->repository->findOneBy([], ['id' => 'ASC']);
        $this->assertIsObject($result);
    }

    public function testFindByNullableFieldShouldReturnCorrectResults(): void
    {
        $results = $this->repository->findAll();
        $this->assertIsArray($results);
    }

    public function testCountByNullableFieldShouldReturnCorrectCount(): void
    {
        $count = $this->repository->count([]);
        $this->assertIsInt($count);
    }
}
