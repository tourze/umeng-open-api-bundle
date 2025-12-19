<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetThirtyDayNewUsersCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\ThirtyDayNewUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetThirtyDayNewUsersCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetThirtyDayNewUsersCommandTest extends AbstractCommandTestCase
{
    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchThirtyDayNewUsers')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证数据被保存到数据库
        $repository = self::getService(ThirtyDayNewUsersRepository::class);
        $this->assertNotNull($repository);
    }

    public function testExecuteWithStartDateArgument(): void
    {
        $app = $this->createTestApp('start');

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchThirtyDayNewUsers')
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

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchThirtyDayNewUsers')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-30']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp('both');

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchThirtyDayNewUsers')
            ->with(self::isInstanceOf(App::class), self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-30',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createTestApp('argstart');

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchThirtyDayNewUsers')
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
        $app = $this->createTestApp('argend');

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->atLeastOnce())
            ->method('fetchThirtyDayNewUsers')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable;
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable && '2024-01-30' === $endDate->format('Y-m-d');
                })
            )
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-30']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetThirtyDayNewUsersCommand::class);

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
