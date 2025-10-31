<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetChannelDataCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyChannelData;
use UmengOpenApiBundle\Repository\ChannelRepository;
use UmengOpenApiBundle\Repository\DailyChannelDataRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetChannelDataCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetChannelDataCommandTest extends AbstractCommandTestCase
{
    private GetChannelDataCommand $command;

    private CommandTester $commandTester;

    /** @var UmengDataFetcherInterface&MockObject */
    private MockObject $dataFetcherMock;

    protected function onSetUp(): void
    {
        $this->dataFetcherMock = $this->createMock(UmengDataFetcherInterface::class);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcherMock);

        $this->command = self::getService(GetChannelDataCommand::class);
        $this->commandTester = new CommandTester($this->command);
    }

    protected function getCommandTester(): CommandTester
    {
        return $this->commandTester;
    }

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $mockResult = $this->createMock(\UmengUappGetChannelDataResult::class);
        $mockResult->method('getChannelInfos')->willReturn([]);

        $this->dataFetcherMock->method('fetchChannelData')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithStartDate(): void
    {
        $app = $this->createApp();
        $startDate = CarbonImmutable::parse('2023-01-01');
        $endDate = CarbonImmutable::parse('2023-01-05');

        $this->expectDataFetcherCalls($app, $startDate, $endDate);

        $exitCode = $this->commandTester->execute([
            'startDate' => '2023-01-01',
            'endDate' => '2023-01-05',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithEndDate(): void
    {
        $app = $this->createApp();
        $endDate = CarbonImmutable::parse('2023-01-31');
        $startDate = CarbonImmutable::parse('2023-01-26');

        $this->expectDataFetcherCalls($app, $startDate, $endDate);

        $exitCode = $this->commandTester->execute([
            'startDate' => '2023-01-26',
            'endDate' => '2023-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createApp();
        $startDate = CarbonImmutable::parse('2023-01-01');
        $endDate = CarbonImmutable::parse('2023-01-31');

        $this->expectDataFetcherCalls($app, $startDate, $endDate);

        $exitCode = $this->commandTester->execute([
            'startDate' => '2023-01-01',
            'endDate' => '2023-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithChannelDataSaving(): void
    {
        $app = $this->createApp();
        $date = CarbonImmutable::today();

        $mockChannelInfo = $this->createMock(\UmengUappChannelInfo::class);
        $mockChannelInfo->method('getId')->willReturn('channel-001');
        $mockChannelInfo->method('getChannel')->willReturn('Test Channel');
        $mockChannelInfo->method('getLaunch')->willReturn(100);
        $mockChannelInfo->method('getDuration')->willReturn('01:30:45');
        $mockChannelInfo->method('getTotalUserRate')->willReturn(0.85);
        $mockChannelInfo->method('getActiveUser')->willReturn(50);
        $mockChannelInfo->method('getNewUser')->willReturn(10);
        $mockChannelInfo->method('getTotalUser')->willReturn(60);

        $mockResult = $this->createMock(\UmengUappGetChannelDataResult::class);
        $mockResult->method('getChannelInfos')->willReturn([$mockChannelInfo]);

        $this->dataFetcherMock
            ->method('fetchChannelData')
            ->with(self::anything(), $date, 1, 100)
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([
            'startDate' => $date->format('Y-m-d'),
            'endDate' => $date->format('Y-m-d'),
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        $channel = $this->getChannelRepository()->findOneBy(['code' => 'channel-001']);
        $this->assertNotNull($channel);
        $this->assertInstanceOf(Channel::class, $channel);
        $this->assertSame('Test Channel', $channel->getName());
        $this->assertSame($app->getAppKey(), $channel->getApp()?->getAppKey());

        $dailyData = $this->getDailyChannelDataRepository()->findOneBy([
            'channel' => $channel,
            'date' => $date,
        ]);
        $this->assertNotNull($dailyData);
        $this->assertInstanceOf(DailyChannelData::class, $dailyData);
        $this->assertSame(100, $dailyData->getLaunch());
        $this->assertSame('5445', $dailyData->getDuration()); // 01:30:45 = 5445 seconds
        $this->assertSame(0.85, $dailyData->getTotalUserRate());
        $this->assertSame(50, $dailyData->getActiveUser());
        $this->assertSame(10, $dailyData->getNewUser());
        $this->assertSame(60, $dailyData->getTotalUser());
    }

    public function testArgumentStartDate(): void
    {
        $mockResult = $this->createMock(\UmengUappGetChannelDataResult::class);
        $mockResult->method('getChannelInfos')->willReturn([]);

        $this->dataFetcherMock
            ->method('fetchChannelData')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute(['startDate' => '2023-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $mockResult = $this->createMock(\UmengUappGetChannelDataResult::class);
        $mockResult->method('getChannelInfos')->willReturn([]);

        $this->dataFetcherMock
            ->method('fetchChannelData')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute(['endDate' => '2023-01-31']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    private function expectDataFetcherCalls(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $mockResult = $this->createMock(\UmengUappGetChannelDataResult::class);
        $mockResult->method('getChannelInfos')->willReturn([]);

        $this->dataFetcherMock
            ->method('fetchChannelData')
            ->with(self::anything(), self::isInstanceOf(CarbonImmutable::class), 1, 100)
            ->willReturn($mockResult)
        ;
    }

    private function createApp(): App
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setApiKey('test-api-key');
        $account->setApiSecurity('test-api-security');
        $account->setValid(true);

        self::getEntityManager()->persist($account);

        $app = new App();
        $app->setAccount($account);
        $app->setAppKey('test-app-key');
        $app->setName('Test App');
        $app->setPlatform('android');
        $app->setPopular(false);
        $app->setUseGameSdk(false);

        self::getEntityManager()->persist($app);
        self::getEntityManager()->flush();

        return $app;
    }

    private function getChannelRepository(): ChannelRepository
    {
        return self::getService(ChannelRepository::class);
    }

    private function getDailyChannelDataRepository(): DailyChannelDataRepository
    {
        return self::getService(DailyChannelDataRepository::class);
    }
}
