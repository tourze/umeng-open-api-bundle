<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyNewUsersCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyNewUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyNewUsersCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyNewUsersCommandTest extends AbstractCommandTestCase
{
    private GetDailyNewUsersCommand $command;

    private CommandTester $commandTester;

    /** @var UmengDataFetcherInterface&MockObject */
    private MockObject $dataFetcherMock;

    /** @var AppRepository&MockObject */
    private MockObject $appRepositoryMock;

    /** @var DailyNewUsersRepository&MockObject */
    private MockObject $newUsersRepositoryMock;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();

        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->method('fetchDailyNewUsers')
            ->willReturn($mockResult)
        ;

        $this->newUsersRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();

        $this->appRepositoryMock->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcherMock
            ->expects($this->once())
            ->method('fetchDailyNewUsers')
            ->with(
                $app,
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable && '2024-01-01' === $startDate->format('Y-m-d');
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable && '2024-01-31' === $endDate->format('Y-m-d');
                })
            )
            ->willReturn($mockResult)
        ;

        $this->newUsersRepositoryMock->method('findOneBy')->willReturn(null);

        $exitCode = $this->commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $mockResult = $this->createMock(\UmengUappGetNewUsersResult::class);
        $mockResult->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcherMock->method('fetchDailyNewUsers')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute(['startDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $mockResult = $this->createMock(\UmengUappGetNewUsersResult::class);
        $mockResult->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcherMock->method('fetchDailyNewUsers')
            ->willReturn($mockResult)
        ;

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
        $this->newUsersRepositoryMock = $this->createMock(DailyNewUsersRepository::class);

        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcherMock);
        self::getContainer()->set(AppRepository::class, $this->appRepositoryMock);
        self::getContainer()->set(DailyNewUsersRepository::class, $this->newUsersRepositoryMock);

        $this->command = self::getService(GetDailyNewUsersCommand::class);
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

    private function createMockResult(): \UmengUappGetNewUsersResult
    {
        $mockCountData = $this->createMock(\UmengUappCountData::class);
        $mockCountData->method('getDate')->willReturn('2024-01-01');
        $mockCountData->method('getValue')->willReturn(200);

        $mockResult = $this->createMock(\UmengUappGetNewUsersResult::class);
        $mockResult->method('getNewUserInfo')->willReturn([$mockCountData]);

        return $mockResult;
    }
}
