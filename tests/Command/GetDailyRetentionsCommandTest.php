<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyRetentionsCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyRetentionsRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyRetentionsCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyRetentionsCommandTest extends AbstractCommandTestCase
{
    private AppRepository&MockObject $appRepository;

    private DailyRetentionsRepository&MockObject $retentionsRepository;

    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();
        $this->appRepository->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->method('fetchDailyRetentions')
            ->willReturn($mockResult)
        ;

        $this->retentionsRepository->method('findOneBy')->willReturn(null);
        // EntityManager interactions are handled by the service

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();
        $this->appRepository->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->once())
            ->method('fetchDailyRetentions')
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

        $this->retentionsRepository->method('findOneBy')->willReturn(null);
        // EntityManager interactions are handled by the service

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createMockApp();
        $this->appRepository->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->method('fetchDailyRetentions')
            ->willReturn($mockResult)
        ;

        $this->retentionsRepository->method('findOneBy')->willReturn(null);

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['startDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $app = $this->createMockApp();
        $this->appRepository->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->method('fetchDailyRetentions')
            ->willReturn($mockResult)
        ;

        $this->retentionsRepository->method('findOneBy')->willReturn(null);

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetDailyRetentionsCommand::class);

        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        $this->appRepository = $this->createMock(AppRepository::class);
        $this->retentionsRepository = $this->createMock(DailyRetentionsRepository::class);
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);

        self::getContainer()->set(AppRepository::class, $this->appRepository);
        self::getContainer()->set(DailyRetentionsRepository::class, $this->retentionsRepository);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
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

    private function createMockResult(): \UmengUappGetRetentionsResult
    {
        $mockRetentionInfo = $this->createMock(\UmengUappRetentionInfo::class);
        $mockRetentionInfo->method('getDate')->willReturn('2024-01-01');
        $mockRetentionInfo->method('getTotalInstallUser')->willReturn(1000);
        $mockRetentionInfo->method('getRetentionRate')->willReturn([0.8, 0.6, 0.5, 0.4, 0.3, 0.25, 0.2]);

        $mockResult = $this->createMock(\UmengUappGetRetentionsResult::class);
        $mockResult->method('getRetentionInfo')->willReturn([$mockRetentionInfo]);

        return $mockResult;
    }
}
