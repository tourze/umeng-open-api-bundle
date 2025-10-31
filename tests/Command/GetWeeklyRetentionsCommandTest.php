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
use UmengOpenApiBundle\Command\GetWeeklyRetentionsCommand;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\WeeklyRetentionsRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetWeeklyRetentionsCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetWeeklyRetentionsCommandTest extends AbstractCommandTestCase
{
    private AppRepository&MockObject $appRepository;

    private WeeklyRetentionsRepository&MockObject $retentionsRepository;

    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([$app])
        ;

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchWeeklyRetentions')
            ->with($app, self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithStartDateArgument(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchWeeklyRetentions')
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['startDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithEndDateArgument(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchWeeklyRetentions')
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-06-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchWeeklyRetentions')
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-06-01',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchWeeklyRetentions')
            ->with(
                $app,
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
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchWeeklyRetentions')
            ->with(
                $app,
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable;
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable && '2024-06-01' === $endDate->format('Y-m-d');
                })
            )
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-06-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetWeeklyRetentionsCommand::class);

        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        $this->appRepository = $this->createMock(AppRepository::class);
        $this->retentionsRepository = $this->createMock(WeeklyRetentionsRepository::class);
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);

        self::getContainer()->set(AppRepository::class, $this->appRepository);
        self::getContainer()->set(WeeklyRetentionsRepository::class, $this->retentionsRepository);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
    }
}
