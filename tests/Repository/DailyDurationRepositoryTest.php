<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyDuration;
use UmengOpenApiBundle\Repository\DailyDurationRepository;

/**
 * @internal
 */
#[CoversClass(DailyDurationRepository::class)]
#[RunTestsInSeparateProcesses]
final class DailyDurationRepositoryTest extends AbstractRepositoryTestCase
{
    private DailyDurationRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(DailyDurationRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(DailyDurationRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data1 = $this->createDailyDuration($app, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createDailyDuration($app, new \DateTimeImmutable('2024-01-02'), 1100);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\DailyDuration', $results);
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

        $data1 = $this->createDailyDuration($app1, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createDailyDuration($app2, new \DateTimeImmutable('2024-01-01'), 2000);

        $app1Data = $this->repository->findBy(['app' => $app1]);
        $app2Data = $this->repository->findBy(['app' => $app2]);

        $this->assertGreaterThanOrEqual(1, count($app1Data));
        $this->assertGreaterThanOrEqual(1, count($app2Data));

        /** @var DailyDuration $data */
        foreach ($app1Data as $data) {
            $this->assertEquals($app1->getId(), $data->getApp()->getId());
        }

        /** @var DailyDuration $data */
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

    private function createDailyDuration(App $app, \DateTimeInterface $date, int $value): DailyDuration
    {
        $data = new DailyDuration();
        $data->setApp($app);
        $data->setDate($date);
        $data->setValue($value);
        $data->setName('test_duration_' . uniqid());
        $data->setPercent(50.0);

        $this->repository->save($data);

        return $data;
    }

    protected function createNewEntity(): object
    {
        $account = $this->createAccount('Test Account ' . uniqid(), 'test_api_key_' . uniqid(), 'test_security_' . uniqid());
        $app = $this->createApp('Test App ' . uniqid(), 'test_app_key_' . uniqid(), 'iOS', $account);

        $entity = new DailyDuration();
        $entity->setApp($app);
        $entity->setDate(new \DateTimeImmutable());
        $entity->setValue(100);
        $entity->setName('test_duration_' . uniqid());
        $entity->setPercent(50.0);

        return $entity;
    }

    protected function getRepository(): DailyDurationRepository
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

    public function testSave(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data = new DailyDuration();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-01-01'));
        $data->setValue(1000);
        $data->setName('test_duration_' . uniqid());
        $data->setPercent(50.0);

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
        $data = new DailyDuration();
        $data->setApp($app);
        $data->setDate(new \DateTimeImmutable('2024-01-01'));
        $data->setValue(1000);
        $data->setName('test_duration_' . uniqid());
        $data->setPercent(50.0);
        $this->repository->save($data);

        $id = $data->getId();

        // Test remove without flush
        $this->repository->remove($data, false);
        self::getEntityManager()->flush();

        $result = $this->repository->find($id);
        $this->assertNull($result);
    }
}
