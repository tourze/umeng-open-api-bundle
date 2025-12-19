<?php

namespace UmengOpenApiBundle\Tests\Command;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyRetentionsCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyRetentions;
use UmengOpenApiBundle\Repository\DailyRetentionsRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyRetentionsCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyRetentionsCommandIntegrationTest extends AbstractCommandTestCase
{
    private UmengDataFetcherInterface $dataFetcher;

    private CommandTester $commandTester;

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetDailyRetentionsCommand::class);
        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        // 只Mock外部API调用，保持内部服务的真实性
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
    }

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        // 创建真实的Account和App实体
        $app = $this->createTestApp();

        // Mock外部API返回结果
        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDailyRetentions')
            ->with(
                self::isInstanceOf(App::class),
                self::isInstanceOf(\Carbon\CarbonImmutable::class),
                self::isInstanceOf(\Carbon\CarbonImmutable::class)
            )
            ->willReturn($mockResult)
        ;

        $command = self::getService(GetDailyRetentionsCommand::class);
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证数据被正确保存到数据库
        $retentionsRepository = self::getService(DailyRetentionsRepository::class);
        $savedRetention = $retentionsRepository->findOneBy([
            'app' => $app,
            'date' => new DateTimeImmutable('2024-01-01'),
        ]);

        $this->assertNotNull($savedRetention);
        $this->assertSame(1000, $savedRetention->getTotalInstallUser());
        $this->assertSame([
            'day_1' => 0.8,
            'day_2' => 0.6,
            'day_3' => 0.5,
            'day_4' => 0.4,
            'day_5' => 0.3,
            'day_6' => 0.25,
            'day_7' => 0.2,
        ], $savedRetention->getRetentionRate());
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDailyRetentions')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    return $startDate instanceof \Carbon\CarbonImmutable && '2024-01-01' === $startDate->format('Y-m-d');
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof \Carbon\CarbonImmutable && '2024-01-31' === $endDate->format('Y-m-d');
                })
            )
            ->willReturn($mockResult)
        ;

        $command = self::getService(GetDailyRetentionsCommand::class);
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证数据库中有正确的数据
        $retentionsRepository = self::getService(DailyRetentionsRepository::class);
        $savedRetention = $retentionsRepository->findOneBy([
            'app' => $app,
            'date' => new DateTimeImmutable('2024-01-01'),
        ]);

        $this->assertNotNull($savedRetention);
        $this->assertSame(1000, $savedRetention->getTotalInstallUser());
    }

    public function testExecuteWithMultipleAppsShouldProcessAll(): void
    {
        // 创建多个App
        $app1 = $this->createTestApp('app1');
        $app2 = $this->createTestApp('app2');

        // 为不同的App准备不同的Mock结果
        $mockResult1 = $this->createMockResult('2024-01-01', 1000);
        $mockResult2 = $this->createMockResult('2024-01-01', 2000);

        // 创建一个返回回调，根据App名称返回不同的结果
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDailyRetentions')
            ->willReturnCallback(function ($app) use ($app1, $app2, $mockResult1, $mockResult2) {
                if ($app->getAppKey() === $app1->getAppKey()) {
                    return $mockResult1;
                } elseif ($app->getAppKey() === $app2->getAppKey()) {
                    return $mockResult2;
                }
                // 其他 App（如 fixtures）返回空结果
                $emptyResult = $this->createMock(\UmengUappGetRetentionsResult::class);
                $emptyResult->method('getRetentionInfo')->willReturn([]);
                return $emptyResult;
            })
        ;

        $command = self::getService(GetDailyRetentionsCommand::class);
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证两个App的数据都被保存
        $retentionsRepository = self::getService(DailyRetentionsRepository::class);
        $retention1 = $retentionsRepository->findOneBy([
            'app' => $app1,
            'date' => new DateTimeImmutable('2024-01-01'),
        ]);
        $retention2 = $retentionsRepository->findOneBy([
            'app' => $app2,
            'date' => new DateTimeImmutable('2024-01-01'),
        ]);

        $this->assertNotNull($retention1);
        $this->assertSame(1000, $retention1->getTotalInstallUser());
        $this->assertNotNull($retention2);
        $this->assertSame(2000, $retention2->getTotalInstallUser());
    }

    public function testArgumentStartDate(): void
    {
        $this->createTestApp('startdate');

        $mockResult = $this->createMock(\UmengUappGetRetentionsResult::class);
        $mockResult->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->method('fetchDailyRetentions')
            ->willReturn($mockResult)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['startDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $this->createTestApp('enddate');

        $mockResult = $this->createMock(\UmengUappGetRetentionsResult::class);
        $mockResult->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->method('fetchDailyRetentions')
            ->willReturn($mockResult)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExistingRecordShouldBeUpdated(): void
    {
        $app = $this->createTestApp();
        $date = new DateTimeImmutable('2024-01-01');

        // 先创建一个现有记录
        $existingRetention = new DailyRetentions();
        $existingRetention->setApp($app);
        $existingRetention->setDate($date);
        $existingRetention->setTotalInstallUser(500);
        $existingRetention->setRetentionRate(['day_1' => 0.5]);

        self::getEntityManager()->persist($existingRetention);
        self::getEntityManager()->flush();

        // Mock API返回新的数据
        $mockResult = $this->createMockResult('2024-01-01', 1000);
        $this->dataFetcher
            ->method('fetchDailyRetentions')
            ->willReturn($mockResult)
        ;

        $command = self::getService(GetDailyRetentionsCommand::class);
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证记录被更新而不是创建新的
        $retentionsRepository = self::getService(DailyRetentionsRepository::class);
        $retention = $retentionsRepository->findOneBy([
            'app' => $app,
            'date' => $date,
        ]);

        $this->assertNotNull($retention);
        $this->assertSame($existingRetention->getId(), $retention->getId());
        $this->assertSame(1000, $retention->getTotalInstallUser());
    }

    private function createTestApp(string $suffix = ''): App
    {
        $account = new Account();
        $account->setName('Test Account ' . $suffix);
        $account->setApiKey('test_api_key_' . $suffix);
        $account->setApiSecurity('test_secret_' . $suffix);
        $account->setValid(true);

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $app = new App();
        $app->setAccount($account);
        $app->setAppKey('test_app_key_' . $suffix);
        $app->setName('Test App ' . $suffix);
        $app->setPlatform('android');
        $app->setPopular(false);
        $app->setUseGameSdk(false);

        self::getEntityManager()->persist($app);
        self::getEntityManager()->flush();

        return $app;
    }

    private function createMockResult(string $date = '2024-01-01', int $totalUsers = 1000): \UmengUappGetRetentionsResult
    {
        $mockRetentionInfo = $this->createMock(\UmengUappRetentionInfo::class);
        $mockRetentionInfo->method('getDate')->willReturn($date);
        $mockRetentionInfo->method('getTotalInstallUser')->willReturn($totalUsers);
        $mockRetentionInfo->method('getRetentionRate')->willReturn([0.8, 0.6, 0.5, 0.4, 0.3, 0.25, 0.2]);

        $mockResult = $this->createMock(\UmengUappGetRetentionsResult::class);
        $mockResult->method('getRetentionInfo')->willReturn([$mockRetentionInfo]);

        return $mockResult;
    }
}