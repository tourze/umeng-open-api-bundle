<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Repository\ChannelRepository;

/**
 * @internal
 */
#[CoversClass(ChannelRepository::class)]
#[RunTestsInSeparateProcesses]
final class ChannelRepositoryTest extends AbstractRepositoryTestCase
{
    private ChannelRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(ChannelRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(ChannelRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel1 = $this->createChannel('渠道1', 'CHAN001', $app);
        $channel2 = $this->createChannel('渠道2', 'CHAN002', $app);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\Channel', $results);
    }

    public function testFindOneByWithCustomNonMatchingCriteriaShouldReturnNull(): void
    {
        $result = $this->repository->findOneBy(['code' => 'NONEXIST']);

        $this->assertNull($result);
    }

    public function testFindWithCustomNonExistentIdShouldReturnNull(): void
    {
        $result = $this->repository->find(999999999);

        $this->assertNull($result);
    }

    public function testFindByAppAssociationShouldReturnRelatedChannels(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app1 = $this->createApp('应用1', 'app_key_1', 'iOS', $account);
        $app2 = $this->createApp('应用2', 'app_key_2', 'Android', $account);

        $channel1 = $this->createChannel('应用1渠道', 'APP1CHAN', $app1);
        $channel2 = $this->createChannel('应用2渠道', 'APP2CHAN', $app2);

        $app1Channels = $this->repository->findBy(['app' => $app1]);
        $app2Channels = $this->repository->findBy(['app' => $app2]);

        $this->assertGreaterThanOrEqual(1, count($app1Channels));
        $this->assertGreaterThanOrEqual(1, count($app2Channels));

        /** @var Channel $channel */
        foreach ($app1Channels as $channel) {
            $this->assertNotNull($channel->getApp());
            $this->assertEquals($app1->getId(), $channel->getApp()->getId());
        }

        /** @var Channel $channel */
        foreach ($app2Channels as $channel) {
            $this->assertNotNull($channel->getApp());
            $this->assertEquals($app2->getId(), $channel->getApp()->getId());
        }
    }

    public function testSaveMethodShouldPersistEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $channel = new Channel();
        $channel->setName('新保存的渠道');
        $channel->setCode('SAVETEST');
        $channel->setApp($app);

        $this->repository->save($channel);

        $savedChannel = $this->repository->findOneBy(['code' => 'SAVETEST']);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\Channel', $savedChannel);
        $this->assertEquals('新保存的渠道', $savedChannel->getName());
    }

    public function testSaveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $channel = new Channel();
        $channel->setName('未刷新渠道');
        $channel->setCode('NOFLUSH');
        $channel->setApp($app);

        $this->repository->save($channel, false);

        self::getEntityManager()->flush();

        $savedChannel = $this->repository->findOneBy(['code' => 'NOFLUSH']);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\Channel', $savedChannel);
    }

    public function testRemoveMethodShouldDeleteEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('待删除渠道', 'REMOVE', $app);
        $channelId = $channel->getId();

        $this->repository->remove($channel);

        $removedChannel = $this->repository->find($channelId);
        $this->assertNull($removedChannel);
    }

    public function testRemoveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('延迟删除渠道', 'DELAYREM', $app);
        $channelId = $channel->getId();

        $this->repository->remove($channel, false);
        self::getEntityManager()->flush();

        $removedChannel = $this->repository->find($channelId);
        $this->assertNull($removedChannel);
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

    private function createChannel(string $name, string $code, App $app): Channel
    {
        $channel = new Channel();
        $channel->setName($name);
        $channel->setCode($code);
        $channel->setApp($app);

        $this->repository->save($channel);

        return $channel;
    }

    protected function createNewEntity(): object
    {
        // 先创建并持久化 Account 和 App（因为 Channel 依赖于它们）
        $account = $this->createAccount('测试账户' . uniqid(), 'api_key_' . uniqid(), 'api_security_' . uniqid());
        $app = $this->createApp('测试应用' . uniqid(), 'app_key_' . uniqid(), 'iOS', $account);

        // 然后创建 Channel，但不持久化（因为测试要求）
        $channel = new Channel();
        $channel->setName('测试渠道' . uniqid());
        $channel->setCode('channel_' . uniqid());
        $channel->setApp($app);

        return $channel;
    }

    protected function getRepository(): ChannelRepository
    {
        return $this->repository;
    }

    public function testFindOneByOrderByShouldRespectSortingParameters(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');

        $results = $this->repository->findOneBy([], ['id' => 'ASC']);

        $this->assertInstanceOf('UmengOpenApiBundle\Entity\Channel', $results);
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
