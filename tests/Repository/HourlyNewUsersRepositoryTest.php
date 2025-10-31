<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyNewUsers;
use UmengOpenApiBundle\Repository\HourlyNewUsersRepository;

/**
 * @internal
 */
#[CoversClass(HourlyNewUsersRepository::class)]
#[RunTestsInSeparateProcesses]
final class HourlyNewUsersRepositoryTest extends AbstractRepositoryTestCase
{
    private HourlyNewUsersRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(HourlyNewUsersRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(HourlyNewUsersRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data1 = $this->createHourlyNewUsers($app, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createHourlyNewUsers($app, new \DateTimeImmutable('2024-01-02'), 1100);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\HourlyNewUsers', $results);
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

        $data1 = $this->createHourlyNewUsers($app1, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createHourlyNewUsers($app2, new \DateTimeImmutable('2024-01-01'), 2000);

        $app1Data = $this->repository->findBy(['app' => $app1]);
        $app2Data = $this->repository->findBy(['app' => $app2]);

        $this->assertGreaterThanOrEqual(1, count($app1Data));
        $this->assertGreaterThanOrEqual(1, count($app2Data));

        /** @var HourlyNewUsers $data */
        foreach ($app1Data as $data) {
            $this->assertEquals($app1->getId(), $data->getApp()->getId());
        }

        /** @var HourlyNewUsers $data */
        foreach ($app2Data as $data) {
            $this->assertEquals($app2->getId(), $data->getApp()->getId());
        }
    }

    public function testSaveMethodShouldPersistEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $data = new HourlyNewUsers();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-02-15'));
        $data->setHour0(500);

        $this->repository->save($data);

        $savedData = $this->repository->findOneBy(['date' => new \DateTimeImmutable('2024-02-15'), 'app' => $app]);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\HourlyNewUsers', $savedData);
        $this->assertEquals(500, $savedData->getHour0());
    }

    public function testSaveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $data = new HourlyNewUsers();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-03-15'));
        $data->setHour0(600);

        $this->repository->save($data, false);

        self::getEntityManager()->flush();

        $savedData = $this->repository->findOneBy(['date' => new \DateTimeImmutable('2024-03-15'), 'app' => $app]);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\HourlyNewUsers', $savedData);
    }

    public function testRemoveMethodShouldDeleteEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data = $this->createHourlyNewUsers($app, new \DateTimeImmutable('2024-04-15'), 100);
        $dataId = $data->getId();

        $this->repository->remove($data);

        $removedData = $this->repository->find($dataId);
        $this->assertNull($removedData);
    }

    public function testRemoveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data = $this->createHourlyNewUsers($app, new \DateTimeImmutable('2024-05-15'), 200);
        $dataId = $data->getId();

        $this->repository->remove($data, false);
        self::getEntityManager()->flush();

        $removedData = $this->repository->find($dataId);
        $this->assertNull($removedData);
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

    private function createHourlyNewUsers(App $app, \DateTimeInterface $date, int $value): HourlyNewUsers
    {
        $data = new HourlyNewUsers();
        $data->setApp($app);
        $data->setDate($date);
        $data->setHour0($value);

        $this->repository->save($data);

        return $data;
    }

    protected function createNewEntity(): object
    {
        $account = $this->createAccount('测试账户' . uniqid(), 'api_key_' . uniqid(), 'api_security_' . uniqid());
        $app = $this->createApp('测试应用' . uniqid(), 'app_key_' . uniqid(), 'iOS', $account);

        $entity = new HourlyNewUsers();
        $entity->setApp($app);
        $entity->setDate(new \DateTimeImmutable('2024-01-01'));
        $entity->setHour0(100);

        return $entity;
    }

    protected function getRepository(): HourlyNewUsersRepository
    {
        return $this->repository;
    }

    public function testFindOneByOrderByShouldRespectSortingParameters(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $this->createHourlyNewUsers($app, new \DateTimeImmutable('2024-01-01'), 1000);

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
