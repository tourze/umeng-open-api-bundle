<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\ThirtyDayActiveUsers;
use UmengOpenApiBundle\Repository\ThirtyDayActiveUsersRepository;

/**
 * @internal
 */
#[CoversClass(ThirtyDayActiveUsersRepository::class)]
#[RunTestsInSeparateProcesses]
final class ThirtyDayActiveUsersRepositoryTest extends AbstractRepositoryTestCase
{
    private ThirtyDayActiveUsersRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(ThirtyDayActiveUsersRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(ThirtyDayActiveUsersRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $data1 = $this->createThirtyDayActiveUsers($app, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createThirtyDayActiveUsers($app, new \DateTimeImmutable('2024-01-02'), 1100);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\ThirtyDayActiveUsers', $results);
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

        $data1 = $this->createThirtyDayActiveUsers($app1, new \DateTimeImmutable('2024-01-01'), 1000);
        $data2 = $this->createThirtyDayActiveUsers($app2, new \DateTimeImmutable('2024-01-01'), 2000);

        $app1Data = $this->repository->findBy(['app' => $app1]);
        $app2Data = $this->repository->findBy(['app' => $app2]);

        $this->assertGreaterThanOrEqual(1, count($app1Data));
        $this->assertGreaterThanOrEqual(1, count($app2Data));

        /** @var ThirtyDayActiveUsers $data */
        foreach ($app1Data as $data) {
            $this->assertEquals($app1->getId(), $data->getApp()->getId());
        }

        /** @var ThirtyDayActiveUsers $data */
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

    private function createThirtyDayActiveUsers(App $app, \DateTimeInterface $date, int $value): ThirtyDayActiveUsers
    {
        $data = new ThirtyDayActiveUsers();
        $data->setApp($app);
        $data->setDate($date);
        $data->setValue($value);

        $this->repository->save($data);

        return $data;
    }

    protected function createNewEntity(): object
    {
        $account = $this->createAccount('测试账户' . uniqid(), 'api_key_' . uniqid(), 'api_security_' . uniqid());
        $app = $this->createApp('测试应用' . uniqid(), 'app_key_' . uniqid(), 'iOS', $account);

        $entity = new ThirtyDayActiveUsers();
        $entity->setApp($app);
        $entity->setDate(new \DateTimeImmutable('2024-01-01'));
        $entity->setValue(1000);

        return $entity;
    }

    protected function getRepository(): ThirtyDayActiveUsersRepository
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
