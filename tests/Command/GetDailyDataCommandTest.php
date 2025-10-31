<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyDataCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyDataRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyDataCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyDataCommandTest extends AbstractCommandTestCase
{
    private GetDailyDataCommand $command;

    private CommandTester $commandTester;

    /** @var UmengDataFetcherInterface&MockObject */
    private MockObject $dataFetcherMock;

    /** @var AppRepository&MockObject */
    private MockObject $appRepositoryMock;

    /** @var DailyDataRepository&MockObject */
    private MockObject $dailyDataRepositoryMock;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();

        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyData')
            ->willReturn($mockResult)
        ;

        $this->dailyDataRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();

        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyData')
            ->willReturn($mockResult)
        ;

        $this->dailyDataRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-02',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createMockApp();
        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyData')
            ->willReturn($mockResult)
        ;

        $this->dailyDataRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute(['startDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $app = $this->createMockApp();
        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyData')
            ->willReturn($mockResult)
        ;

        $this->dailyDataRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute(['endDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        return $this->commandTester;
    }

    protected function onSetUp(): void
    {
        // Mock所有依赖
        $this->dataFetcherMock = $this->createMock(UmengDataFetcherInterface::class);
        $this->appRepositoryMock = $this->createMock(AppRepository::class);
        $this->dailyDataRepositoryMock = $this->createMock(DailyDataRepository::class);

        // 注入到容器中
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcherMock);
        self::getContainer()->set(AppRepository::class, $this->appRepositoryMock);
        self::getContainer()->set(DailyDataRepository::class, $this->dailyDataRepositoryMock);

        $this->command = self::getService(GetDailyDataCommand::class);
        $this->commandTester = new CommandTester($this->command);
    }

    private function createMockApp(): App
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setApiKey('test-api-key');
        $account->setApiSecurity('test-api-security');
        $account->setValid(true);

        self::getEntityManager()->persist($account);

        $app = new App();
        $app->setAccount($account);
        $app->setAppKey('test_app_key');
        $app->setName('Test App');
        $app->setPlatform('android');
        $app->setPopular(false);
        $app->setUseGameSdk(false);

        self::getEntityManager()->persist($app);
        self::getEntityManager()->flush();

        return $app;
    }

    /**
     * @return \UmengUappGetDailyDataResult
     */
    private function createMockResult()
    {
        $mockDailyData = $this->getMockBuilder(\UmengUappDailyDataInfo::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockDailyData->method('getNewUsers')->willReturn(100);
        $mockDailyData->method('getTotalUsers')->willReturn(1000);
        $mockDailyData->method('getActivityUsers')->willReturn(500);
        $mockDailyData->method('getLaunches')->willReturn(2000);
        $mockDailyData->method('getPayUsers')->willReturn(50);

        $mockResult = $this->getMockBuilder(\UmengUappGetDailyDataResult::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockResult->method('getDailyData')->willReturn($mockDailyData);

        return $mockResult;
    }
}
