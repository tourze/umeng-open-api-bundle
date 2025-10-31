<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyDurationCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyDurationRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyDurationCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyDurationCommandTest extends AbstractCommandTestCase
{
    private GetDailyDurationCommand $command;

    private CommandTester $commandTester;

    /** @var UmengDataFetcherInterface&MockObject */
    private MockObject $dataFetcherMock;

    /** @var AppRepository&MockObject */
    private MockObject $appRepositoryMock;

    /** @var DailyDurationRepository&MockObject */
    private MockObject $dailyDurationRepositoryMock;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();

        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDurationData')
            ->willReturn($mockResult)
        ;

        $this->dailyDurationRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();

        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDurationData')
            ->willReturn($mockResult)
        ;

        $this->dailyDurationRepositoryMock->method('findOneBy')->willReturn(null);

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
            ->method('fetchDurationData')
            ->willReturn($mockResult)
        ;

        $this->dailyDurationRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute(['startDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $app = $this->createMockApp();
        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDurationData')
            ->willReturn($mockResult)
        ;

        $this->dailyDurationRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute(['endDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        return $this->commandTester;
    }

    protected function onSetUp(): void
    {
        $this->dataFetcherMock = $this->createMock(UmengDataFetcherInterface::class);
        $this->appRepositoryMock = $this->createMock(AppRepository::class);
        $this->dailyDurationRepositoryMock = $this->createMock(DailyDurationRepository::class);

        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcherMock);
        self::getContainer()->set(AppRepository::class, $this->appRepositoryMock);
        self::getContainer()->set(DailyDurationRepository::class, $this->dailyDurationRepositoryMock);

        $this->command = self::getService(GetDailyDurationCommand::class);
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

    private function createMockResult(): \UmengUappGetDurationsResult
    {
        $mockDurationInfo = $this->getMockBuilder(\UmengUappDurationInfo::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockDurationInfo->method('getName')->willReturn('0-10s');
        $mockDurationInfo->method('getValue')->willReturn(100);
        $mockDurationInfo->method('getPercent')->willReturn(25.5);

        $mockResult = $this->getMockBuilder(\UmengUappGetDurationsResult::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockResult->method('getDurationInfos')->willReturn([$mockDurationInfo]);

        return $mockResult;
    }
}
