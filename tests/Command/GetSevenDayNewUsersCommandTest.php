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
use UmengOpenApiBundle\Command\GetSevenDayNewUsersCommand;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\SevenDaysNewUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetSevenDayNewUsersCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetSevenDayNewUsersCommandTest extends AbstractCommandTestCase
{
    private AppRepository&MockObject $appRepository;

    private SevenDaysNewUsersRepository&MockObject $sevenDaysNewUsersRepository;

    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([$app])
        ;

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchSevenDayNewUsers')
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

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchSevenDayNewUsers')
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

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchSevenDayNewUsers')
            ->willReturn($result)
        ;

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-07']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchSevenDayNewUsers')
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
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchSevenDayNewUsers')
            ->with(
                $app,
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable && '2024-01-01' === $startDate->format('Y-m-d');
                }),
                self::callback(function ($endDate) {
                    // When only startDate is provided, endDate defaults to today
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
        $app = $this->createMock(App::class);
        $this->appRepository->method('findAll')->willReturn([$app]);

        $result = $this->createMock(\UmengUappGetNewUsersResult::class);
        $result->method('getNewUserInfo')->willReturn([]);

        $this->dataFetcher->expects($this->once())
            ->method('fetchSevenDayNewUsers')
            ->with(
                $app,
                self::callback(function ($startDate) {
                    // When only endDate is provided, startDate = endDate - 7 days
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
        $command = self::getService(GetSevenDayNewUsersCommand::class);

        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        $this->appRepository = $this->createMock(AppRepository::class);
        $this->sevenDaysNewUsersRepository = $this->createMock(SevenDaysNewUsersRepository::class);
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);

        self::getContainer()->set(AppRepository::class, $this->appRepository);
        self::getContainer()->set(SevenDaysNewUsersRepository::class, $this->sevenDaysNewUsersRepository);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
    }
}
