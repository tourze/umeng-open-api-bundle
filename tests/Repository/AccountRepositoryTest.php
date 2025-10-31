<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Repository\AccountRepository;

/**
 * @internal
 */
#[CoversClass(AccountRepository::class)]
#[RunTestsInSeparateProcesses]
final class AccountRepositoryTest extends AbstractRepositoryTestCase
{
    private AccountRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(AccountRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(AccountRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account1 = $this->createAccount('测试账户1', 'api_key_1', 'api_security_1');
        $account2 = $this->createAccount('测试账户2', 'api_key_2', 'api_security_2');

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\Account', $results);
    }

    public function testFindOneByWithCustomNonMatchingCriteriaShouldReturnNull(): void
    {
        $result = $this->repository->findOneBy(['apiKey' => 'non_existent_key']);

        $this->assertNull($result);
    }

    public function testFindWithCustomNonExistentIdShouldReturnNull(): void
    {
        $result = $this->repository->find(999999999);

        $this->assertNull($result);
    }

    public function testSaveMethodShouldPersistEntity(): void
    {
        $account = new Account();
        $account->setName('新保存的账户');
        $account->setApiKey('save_test_key');
        $account->setApiSecurity('save_test_security');
        $account->setValid(true);

        $this->repository->save($account);

        $savedAccount = $this->repository->findOneBy(['apiKey' => 'save_test_key']);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\Account', $savedAccount);
        $this->assertEquals('新保存的账户', $savedAccount->getName());
    }

    public function testSaveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = new Account();
        $account->setName('未刷新账户');
        $account->setApiKey('no_flush_key');
        $account->setApiSecurity('no_flush_security');
        $account->setValid(true);

        $this->repository->save($account, false);

        self::getEntityManager()->flush();

        $savedAccount = $this->repository->findOneBy(['apiKey' => 'no_flush_key']);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\Account', $savedAccount);
    }

    public function testRemoveMethodShouldDeleteEntity(): void
    {
        $account = $this->createAccount('待删除账户', 'remove_key', 'remove_security');
        $accountId = $account->getId();

        $this->repository->remove($account);

        $removedAccount = $this->repository->find($accountId);
        $this->assertNull($removedAccount);
    }

    public function testRemoveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('延迟删除账户', 'delayed_remove_key', 'delayed_remove_security');
        $accountId = $account->getId();

        $this->repository->remove($account, false);
        self::getEntityManager()->flush();

        $removedAccount = $this->repository->find($accountId);
        $this->assertNull($removedAccount);
    }

    private function createAccount(string $name, string $apiKey, string $apiSecurity, ?bool $valid = true): Account
    {
        $account = new Account();
        $account->setName($name);
        $account->setApiKey($apiKey);
        $account->setApiSecurity($apiSecurity);
        $account->setValid($valid);

        $this->repository->save($account);

        return $account;
    }

    protected function createNewEntity(): object
    {
        $account = new Account();
        $account->setName('测试账户' . uniqid());
        $account->setApiKey('api_key_' . uniqid());
        $account->setApiSecurity('api_security_' . uniqid());
        $account->setValid(true);

        return $account;
    }

    protected function getRepository(): AccountRepository
    {
        return $this->repository;
    }

    public function testFindOneByOrderByShouldRespectSortingParameters(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $results = $this->repository->findOneBy([], ['id' => 'ASC']);

        $this->assertInstanceOf('UmengOpenApiBundle\Entity\Account', $results);
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
}
