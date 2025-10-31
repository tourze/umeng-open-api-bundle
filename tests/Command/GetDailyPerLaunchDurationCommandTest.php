<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyPerLaunchDurationCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyPerLaunchDurationRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyPerLaunchDurationCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyPerLaunchDurationCommandTest extends AbstractCommandTestCase
{
    private GetDailyPerLaunchDurationCommand $command;

    private CommandTester $commandTester;

    /** @var UmengDataFetcherInterface&MockObject */
    private MockObject $dataFetcherMock;

    /** @var AppRepository&MockObject */
    private MockObject $appRepositoryMock;

    /** @var DailyPerLaunchDurationRepository&MockObject */
    private MockObject $durationRepositoryMock;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();

        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDurationData')
            ->willReturn($mockResult)
        ;

        $this->durationRepositoryMock->method('findOneBy')->willReturn(null);

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

        $this->durationRepositoryMock->method('findOneBy')->willReturn(null);

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

        $this->durationRepositoryMock->method('findOneBy')->willReturn(null);

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

        $this->durationRepositoryMock->method('findOneBy')->willReturn(null);

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
        $this->durationRepositoryMock = $this->createMock(DailyPerLaunchDurationRepository::class);

        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcherMock);
        self::getContainer()->set(AppRepository::class, $this->appRepositoryMock);
        self::getContainer()->set(DailyPerLaunchDurationRepository::class, $this->durationRepositoryMock);

        $this->command = self::getService(GetDailyPerLaunchDurationCommand::class);
        $this->commandTester = new CommandTester($this->command);
    }

    private function createMockApp(): App
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setApiKey('test_api_key');
        $account->setApiSecurity('test_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

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
        $mockDurationInfo = $this->createMock(\UmengUappDurationInfo::class);
        $mockDurationInfo->method('getName')->willReturn('0-10s');
        $mockDurationInfo->method('getValue')->willReturn(150);
        $mockDurationInfo->method('getPercent')->willReturn(30.5);

        $mockResult = $this->createMock(\UmengUappGetDurationsResult::class);
        $mockResult->method('getDurationInfos')->willReturn([$mockDurationInfo]);

        return $mockResult;
    }
}
