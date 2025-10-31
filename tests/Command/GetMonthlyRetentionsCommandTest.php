<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetMonthlyRetentionsCommand;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\MonthlyRetentionsRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetMonthlyRetentionsCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetMonthlyRetentionsCommandTest extends AbstractCommandTestCase
{
    /** @var MockObject&UmengDataFetcherInterface */
    private UmengDataFetcherInterface $dataFetcher;

    /** @var MockObject&AppRepository */
    private AppRepository $appRepository;

    /** @var MockObject&MonthlyRetentionsRepository */
    private MonthlyRetentionsRepository $retentionsRepository;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $this->dataFetcher
            ->expects($this->once())
            ->method('fetchMonthlyRetentions')
            ->with($app, self::isInstanceOf(CarbonImmutable::class), self::isInstanceOf(CarbonImmutable::class))
            ->willReturn($result)
        ;

        $exitCode = $this->getCommandTester()->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $expectedStartDate = CarbonImmutable::parse('2024-01-01')->startOfDay();
        $this->dataFetcher
            ->expects($this->once())
            ->method('fetchMonthlyRetentions')
            ->with(
                $app,
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
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $expectedEndDate = CarbonImmutable::parse('2024-01-31')->startOfDay();
        $this->dataFetcher
            ->expects($this->once())
            ->method('fetchMonthlyRetentions')
            ->with(
                $app,
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
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetRetentionsResult::class);
        $result->method('getRetentionInfo')->willReturn([]);

        $expectedStartDate = CarbonImmutable::parse('2024-01-01')->startOfDay();
        $expectedEndDate = CarbonImmutable::parse('2024-01-31')->startOfDay();
        $this->dataFetcher
            ->expects($this->once())
            ->method('fetchMonthlyRetentions')
            ->with(
                $app,
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
        $command = self::getService(GetMonthlyRetentionsCommand::class);

        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);
        $this->appRepository = $this->createMock(AppRepository::class);
        $this->retentionsRepository = $this->createMock(MonthlyRetentionsRepository::class);

        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
        self::getContainer()->set(AppRepository::class, $this->appRepository);
        self::getContainer()->set(MonthlyRetentionsRepository::class, $this->retentionsRepository);
    }
}
