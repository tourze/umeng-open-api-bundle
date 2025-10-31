<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetHourlyActiveUsersCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyActiveUsers;
use UmengOpenApiBundle\Repository\HourlyActiveUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetHourlyActiveUsersCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetHourlyActiveUsersCommandTest extends AbstractCommandTestCase
{
    private GetHourlyActiveUsersCommand $command;

    private CommandTester $commandTester;

    /** @var UmengDataFetcherInterface&MockObject */
    private MockObject $dataFetcherMock;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $account = $this->createAccount();
        $app = $this->createApp($account);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchHourlyActiveUsers')
            ->willReturn($mockResult)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // Verify data was persisted
        $savedData = $this->getHourlyActiveUsersRepository()->findOneBy(['app' => $app]);
        $this->assertNotNull($savedData);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $account = $this->createAccount();
        $app = $this->createApp($account);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->expects($this->atLeastOnce())
            ->method('fetchHourlyActiveUsers')
            ->with(
                self::callback(function ($appArg) {
                    return $appArg instanceof App;
                }),
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
        return $this->commandTester;
    }

    protected function onSetUp(): void
    {
        $this->dataFetcherMock = $this->createMock(UmengDataFetcherInterface::class);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcherMock);

        $this->command = self::getService(GetHourlyActiveUsersCommand::class);
        $this->commandTester = new CommandTester($this->command);
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

    private function createApp(Account $account): App
    {
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

    private function createMockResult(): \UmengUappGetActiveUsersResult
    {
        $mockCountData = $this->createMock(\UmengUappCountData::class);
        $mockCountData->method('getDate')->willReturn('2024-01-01');
        $mockCountData->method('getHourValue')->willReturn([0 => 100, 1 => 200]);

        $mockResult = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $mockResult->method('getActiveUserInfo')->willReturn([$mockCountData]);

        return $mockResult;
    }

    public function testArgumentStartDate(): void
    {
        $account = $this->createAccount();
        $app = $this->createApp($account);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock->method('fetchHourlyActiveUsers')->willReturn($mockResult);

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['startDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $account = $this->createAccount();
        $app = $this->createApp($account);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock->method('fetchHourlyActiveUsers')->willReturn($mockResult);

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-31']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    private function getHourlyActiveUsersRepository(): HourlyActiveUsersRepository
    {
        return self::getService(HourlyActiveUsersRepository::class);
    }
}
