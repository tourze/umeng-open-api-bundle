<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetMonthlyLaunchesCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetMonthlyLaunchesCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetMonthlyLaunchesCommandTest extends AbstractCommandTestCase
{
    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $result = $this->createMock(\UmengUappGetLaunchesResult::class);
        $result->method('getLaunchInfo')->willReturn([]);

        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchMonthlyLaunches')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $exitCode = $this->getCommandTester()->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createTestApp();

        $result = $this->createMock(\UmengUappGetLaunchesResult::class);
        $result->method('getLaunchInfo')->willReturn([]);

        $expectedStartDate = CarbonImmutable::parse('2024-01-01')->startOfDay();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchMonthlyLaunches')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(fn (mixed $date): bool => $date instanceof CarbonImmutable && $date->equalTo($expectedStartDate)),
                self::isInstanceOf(CarbonImmutable::class)
            )
            ->willReturn($result)
        ;

        $exitCode = $this->getCommandTester()->execute(['startDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $app = $this->createTestApp();

        $result = $this->createMock(\UmengUappGetLaunchesResult::class);
        $result->method('getLaunchInfo')->willReturn([]);

        $expectedEndDate = CarbonImmutable::parse('2024-01-31')->startOfDay();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchMonthlyLaunches')
            ->with(
                self::isInstanceOf(App::class),
                self::isInstanceOf(CarbonImmutable::class),
                self::callback(fn (mixed $date): bool => $date instanceof CarbonImmutable && $date->equalTo($expectedEndDate))
            )
            ->willReturn($result)
        ;

        $exitCode = $this->getCommandTester()->execute(['endDate' => '2024-01-31']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $result = $this->createMock(\UmengUappGetLaunchesResult::class);
        $result->method('getLaunchInfo')->willReturn([]);

        $expectedStartDate = CarbonImmutable::parse('2024-01-01')->startOfDay();
        $expectedEndDate = CarbonImmutable::parse('2024-01-31')->startOfDay();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchMonthlyLaunches')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(fn (mixed $date): bool => $date instanceof CarbonImmutable && $date->equalTo($expectedStartDate)),
                self::callback(fn (mixed $date): bool => $date instanceof CarbonImmutable && $date->equalTo($expectedEndDate))
            )
            ->willReturn($result)
        ;

        $exitCode = $this->getCommandTester()->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetMonthlyLaunchesCommand::class);

        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);

        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
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
}
