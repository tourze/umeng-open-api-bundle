<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetWeeklyLaunchesCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\WeeklyLaunches;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetWeeklyLaunchesCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetWeeklyLaunchesCommandTest extends AbstractCommandTestCase
{
    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchWeeklyLaunches')
            ->willReturn($mockResult)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // Verify data was persisted
        $savedLaunches = self::getEntityManager()
            ->getRepository(WeeklyLaunches::class)
            ->findBy(['app' => $app])
        ;
        $this->assertNotEmpty($savedLaunches);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchWeeklyLaunches')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable && '2024-01-01' === $startDate->format('Y-m-d');
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable && '2024-01-31' === $endDate->format('Y-m-d');
                })
            )
            ->willReturn($mockResult)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetWeeklyLaunchesCommand::class);

        return new CommandTester($command);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createApp();
        $result = $this->createMockResult();

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchWeeklyLaunches')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable && '2024-01-01' === $startDate->format('Y-m-d');
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable;
                })
            )
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['startDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $app = $this->createApp();
        $result = $this->createMockResult();

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchWeeklyLaunches')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable;
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable && '2024-01-07' === $endDate->format('Y-m-d');
                })
            )
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-07']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function onSetUp(): void
    {
        // Create a fresh mock for each test method
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
    }

    private function createApp(): App
    {
        $account = $this->createAccount();

        $app = new App();
        $app->setAccount($account);
        $app->setAppKey('test_app_key');
        $app->setName('Test App');
        $app->setPlatform('android');
        $app->setPopular(true);
        $app->setUseGameSdk(false);

        self::getEntityManager()->persist($app);
        self::getEntityManager()->flush();

        return $app;
    }

    private function createAccount(): Account
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setApiKey('test-api-key');
        $account->setApiSecurity('test-api-security');
        $account->setValid(true);

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        return $account;
    }

    private function createMockResult(): \UmengUappGetLaunchesResult
    {
        $mockCountData = $this->createMock(\UmengUappCountData::class);
        $mockCountData->method('getDate')->willReturn('2024-01-01');
        $mockCountData->method('getValue')->willReturn(1000);

        $mockResult = $this->createMock(\UmengUappGetLaunchesResult::class);
        $mockResult->method('getLaunchInfo')->willReturn([$mockCountData]);

        return $mockResult;
    }
}
