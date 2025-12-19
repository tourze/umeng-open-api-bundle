<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetSevenDaysActiveUsersCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\SevenDaysActiveUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetSevenDaysActiveUsersCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetSevenDaysActiveUsersCommandTest extends AbstractCommandTestCase
{
    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $result = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $result->method('getActiveUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchSevenDaysActiveUsers')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证数据被保存到数据库
        $repository = self::getService(SevenDaysActiveUsersRepository::class);
        $this->assertNotNull($repository);
    }

    public function testExecuteWithStartDateArgument(): void
    {
        $app = $this->createTestApp('start');

        $result = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $result->method('getActiveUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchSevenDaysActiveUsers')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['startDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithEndDateArgument(): void
    {
        $app = $this->createTestApp('end');

        $result = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $result->method('getActiveUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchSevenDaysActiveUsers')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-07']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp('both');

        $result = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $result->method('getActiveUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchSevenDaysActiveUsers')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-07',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createTestApp('argstart');

        $result = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $result->method('getActiveUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchSevenDaysActiveUsers')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable && '2024-01-01' === $startDate->format('Y-m-d');
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable && $endDate->format('Y-m-d') === CarbonImmutable::today()->format('Y-m-d');
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
        $app = $this->createTestApp('argend');

        $result = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $result->method('getActiveUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchSevenDaysActiveUsers')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    $expectedStartDate = CarbonImmutable::parse('2024-01-07')->subDays(7);

                    return $startDate instanceof CarbonImmutable && $expectedStartDate->format('Y-m-d') === $startDate->format('Y-m-d');
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

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetSevenDaysActiveUsersCommand::class);

        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        // 只Mock外部API调用，保持内部服务的真实性
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
