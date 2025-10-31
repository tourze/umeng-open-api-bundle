<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetHourlyLaunchesCommand;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyLaunches;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\HourlyLaunchesRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetHourlyLaunchesCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetHourlyLaunchesCommandTest extends AbstractCommandTestCase
{
    private UmengDataFetcherInterface&MockObject $dataFetcher;

    private AppRepository&MockObject $appRepository;

    private HourlyLaunchesRepository&MockObject $launchesRepository;

    private PropertyAccessor&MockObject $propertyAccessor;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createMockApp();
        $this->appRepository->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->method('fetchHourlyLaunches')
            ->willReturn($mockResult)
        ;

        $this->launchesRepository->method('findOneBy')->willReturn(null);
        $this->propertyAccessor->method('setValue');
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
            ->method('fetchHourlyLaunches')
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

        $this->launchesRepository->method('findOneBy')->willReturn(null);
        $this->propertyAccessor->method('setValue');
        // EntityManager interactions are handled by the service

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(GetHourlyLaunchesCommand::class);

        return new CommandTester($command);
    }

    protected function onSetUp(): void
    {
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);
        $this->appRepository = $this->createMock(AppRepository::class);
        $this->launchesRepository = $this->createMock(HourlyLaunchesRepository::class);
        $this->propertyAccessor = $this->createMock(PropertyAccessor::class);

        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);
        self::getContainer()->set(AppRepository::class, $this->appRepository);
        self::getContainer()->set(HourlyLaunchesRepository::class, $this->launchesRepository);
        self::getContainer()->set(PropertyAccessor::class, $this->propertyAccessor);
    }

    private function createMockApp(): App
    {
        $app = new App();
        $app->setName('Test App');
        $app->setAppKey('test_app_key');
        $app->setPlatform('ios');

        $persistedApp = $this->persistAndFlush($app);
        self::assertInstanceOf(App::class, $persistedApp);

        return $persistedApp;
    }

    private function createMockResult(): \UmengUappGetLaunchesResult
    {
        $mockCountData = $this->createMock(\UmengUappCountData::class);
        $mockCountData->method('getDate')->willReturn('2024-01-01');
        $mockCountData->method('getHourValue')->willReturn([0 => 100, 1 => 200]);

        $mockResult = $this->createMock(\UmengUappGetLaunchesResult::class);
        $mockResult->method('getLaunchInfo')->willReturn([$mockCountData]);

        return $mockResult;
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createMockApp();
        $this->appRepository->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcher->method('fetchHourlyLaunches')->willReturn($mockResult);
        $this->launchesRepository->method('findOneBy')->willReturn(null);
        $this->propertyAccessor->method('setValue');
        // EntityManager interactions are handled by the service

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['startDate' => '2024-01-01']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $app = $this->createMockApp();
        $this->appRepository->method('findAll')->willReturn([$app]);

        $mockResult = $this->createMockResult();
        $this->dataFetcher->method('fetchHourlyLaunches')->willReturn($mockResult);
        $this->launchesRepository->method('findOneBy')->willReturn(null);
        $this->propertyAccessor->method('setValue');
        // EntityManager interactions are handled by the service

        $commandTester = $this->getCommandTester();
        $exitCode = $commandTester->execute(['endDate' => '2024-01-31']);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }
}
