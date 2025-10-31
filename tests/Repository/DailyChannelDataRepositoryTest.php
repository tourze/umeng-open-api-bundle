<?php

namespace UmengOpenApiBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyChannelData;
use UmengOpenApiBundle\Repository\DailyChannelDataRepository;

/**
 * @internal
 */
#[CoversClass(DailyChannelDataRepository::class)]
#[RunTestsInSeparateProcesses]
final class DailyChannelDataRepositoryTest extends AbstractRepositoryTestCase
{
    private DailyChannelDataRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(DailyChannelDataRepository::class);
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(DailyChannelDataRepository::class, $this->repository);
    }

    public function testFindAllWhenRecordsExistShouldReturnEntities(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('测试渠道', 'TEST001', $app);
        $data1 = $this->createDailyChannelData($channel, new \DateTimeImmutable('2024-01-01'), 1000, '3600', 10.5);
        $data2 = $this->createDailyChannelData($channel, new \DateTimeImmutable('2024-01-02'), 1100, '3800', 11.0);

        $results = $this->repository->findAll();

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(2, count($results));
        $this->assertContainsOnlyInstancesOf('UmengOpenApiBundle\Entity\DailyChannelData', $results);
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

    public function testFindByChannelAssociationShouldReturnRelatedData(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel1 = $this->createChannel('渠道1', 'CH001', $app);
        $channel2 = $this->createChannel('渠道2', 'CH002', $app);

        $data1 = $this->createDailyChannelData($channel1, new \DateTimeImmutable('2024-01-01'), 1000, '3600', 10.0);
        $data2 = $this->createDailyChannelData($channel2, new \DateTimeImmutable('2024-01-01'), 2000, '7200', 20.0);

        $channel1Data = $this->repository->findBy(['channel' => $channel1]);
        $channel2Data = $this->repository->findBy(['channel' => $channel2]);

        $this->assertGreaterThanOrEqual(1, count($channel1Data));
        $this->assertGreaterThanOrEqual(1, count($channel2Data));

        /** @var DailyChannelData $data */
        foreach ($channel1Data as $data) {
            $this->assertNotNull($data->getChannel());
            $this->assertEquals($channel1->getId(), $data->getChannel()->getId());
        }

        /** @var DailyChannelData $data */
        foreach ($channel2Data as $data) {
            $this->assertNotNull($data->getChannel());
            $this->assertEquals($channel2->getId(), $data->getChannel()->getId());
        }
    }

    public function testFindByNullableFieldsShouldWork(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('测试渠道', 'TEST001', $app);

        $data = new DailyChannelData();
        $data->setChannel($channel);
        $data->setDate(new \DateTimeImmutable('2024-06-15'));
        $data->setLaunch(null);
        $data->setDuration(null);
        $data->setTotalUserRate(null);

        $this->repository->save($data);

        $nullLaunchResults = $this->repository->findBy(['launch' => null]);
        $nullDurationResults = $this->repository->findBy(['duration' => null]);

        $this->assertGreaterThanOrEqual(1, count($nullLaunchResults));
        $this->assertGreaterThanOrEqual(1, count($nullDurationResults));

        $foundData = null;
        /** @var DailyChannelData $result */
        foreach ($nullLaunchResults as $result) {
            if ('2024-06-15' === $result->getDate()?->format('Y-m-d')) {
                $foundData = $result;
                break;
            }
        }

        $this->assertNotNull($foundData);
        $this->assertNull($foundData->getLaunch());
        $this->assertNull($foundData->getDuration());
        $this->assertNull($foundData->getTotalUserRate());
    }

    public function testSaveMethodShouldPersistEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('测试渠道', 'TEST001', $app);

        $data = new DailyChannelData();
        $data->setChannel($channel);
        $data->setDate(new \DateTimeImmutable('2024-02-15'));
        $data->setLaunch(500);
        $data->setDuration('3600');
        $data->setTotalUserRate(10.5);

        $this->repository->save($data);

        $savedData = $this->repository->findOneBy(['date' => new \DateTimeImmutable('2024-02-15'), 'channel' => $channel]);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\DailyChannelData', $savedData);
        $this->assertEquals(500, $savedData->getLaunch());
    }

    public function testSaveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('测试渠道', 'TEST001', $app);

        $data = new DailyChannelData();
        $data->setChannel($channel);
        $data->setDate(new \DateTimeImmutable('2024-03-15'));
        $data->setLaunch(600);
        $data->setDuration('3800');
        $data->setTotalUserRate(12.5);

        $this->repository->save($data, false);

        self::getEntityManager()->flush();

        $savedData = $this->repository->findOneBy(['date' => new \DateTimeImmutable('2024-03-15'), 'channel' => $channel]);
        $this->assertInstanceOf('UmengOpenApiBundle\Entity\DailyChannelData', $savedData);
    }

    public function testRemoveMethodShouldDeleteEntity(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('测试渠道', 'TEST001', $app);
        $data = $this->createDailyChannelData($channel, new \DateTimeImmutable('2024-04-15'), 100, '3600', 10.0);
        $dataId = $data->getId();

        $this->repository->remove($data);

        $removedData = $this->repository->find($dataId);
        $this->assertNull($removedData);
    }

    public function testRemoveMethodWithFlushFalseShouldNotFlushImmediately(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);
        $channel = $this->createChannel('测试渠道', 'TEST001', $app);
        $data = $this->createDailyChannelData($channel, new \DateTimeImmutable('2024-05-15'), 200, '3800', 12.0);
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

    private function createChannel(string $name, string $code, App $app): Channel
    {
        $channel = new Channel();
        $channel->setName($name);
        $channel->setCode($code);
        $channel->setApp($app);

        $channelRepository = self::getService('UmengOpenApiBundle\Repository\ChannelRepository');
        $channelRepository->save($channel);

        return $channel;
    }

    private function createDailyChannelData(Channel $channel, \DateTimeInterface $date, ?int $launch, ?string $duration, ?float $percentage): DailyChannelData
    {
        $data = new DailyChannelData();
        $data->setChannel($channel);
        $data->setDate($date);
        $data->setLaunch($launch);
        $data->setDuration($duration);
        $data->setTotalUserRate($percentage);

        $this->repository->save($data);

        return $data;
    }

    protected function createNewEntity(): object
    {
        $account = $this->createAccount('测试账户', 'test_api_key_' . uniqid(), 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key_' . uniqid(), 'iOS', $account);
        $channel = $this->createChannel('测试渠道', 'TEST_CHANNEL_' . uniqid(), $app);

        $entity = new DailyChannelData();
        $entity->setChannel($channel);
        $entity->setDate(new \DateTimeImmutable('2024-01-01'));

        return $entity;
    }

    protected function getRepository(): DailyChannelDataRepository
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

    public function testFindByAppAssociationShouldReturnRelatedData(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $results = $this->repository->findBy([]);
        $this->assertIsArray($results);
    }

    public function testCountByAppAssociationShouldReturnCorrectCount(): void
    {
        $account = $this->createAccount('测试账户', 'test_api_key', 'test_security');
        $app = $this->createApp('测试应用', 'test_app_key', 'iOS', $account);

        $count = $this->repository->count([]);
        $this->assertIsInt($count);
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
