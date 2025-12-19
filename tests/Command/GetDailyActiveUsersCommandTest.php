<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyActiveUsersCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyActiveUsers;
use UmengOpenApiBundle\Repository\DailyActiveUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyActiveUsersCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyActiveUsersCommandTest extends AbstractCommandTestCase
{
    private GetDailyActiveUsersCommand $command;

    private CommandTester $commandTester;

    private UmengDataFetcherInterface $dataFetcherMock;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $account = $this->createAccount();
        $app = $this->createApp($account);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyActiveUsers')
            ->willReturn($mockResult)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // Verify data was persisted
        $savedData = $this->getDailyActiveUsersRepository()->findOneBy(['app' => $app]);
        $this->assertNotNull($savedData);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $account = $this->createAccount();
        $app = $this->createApp($account);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyActiveUsers')
            ->with(
                self::anything(),
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

    public function testArgumentStartDate(): void
    {
        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyActiveUsers')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute(['startDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyActiveUsers')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute(['endDate' => '2024-01-31']);
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

        $this->command = self::getService(GetDailyActiveUsersCommand::class);
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
        $mockCountData->method('getValue')->willReturn(5000);

        $mockResult = $this->createMock(\UmengUappGetActiveUsersResult::class);
        $mockResult->method('getActiveUserInfo')->willReturn([$mockCountData]);

        return $mockResult;
    }

    private function getDailyActiveUsersRepository(): DailyActiveUsersRepository
    {
        return self::getService(DailyActiveUsersRepository::class);
    }
}
