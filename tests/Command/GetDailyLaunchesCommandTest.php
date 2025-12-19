<?php

namespace UmengOpenApiBundle\Tests\Command;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyLaunchesCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\DailyLaunchesRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyLaunchesCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyLaunchesCommandTest extends AbstractCommandTestCase
{
    private GetDailyLaunchesCommand $command;

    private CommandTester $commandTester;

    private MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->method('fetchDailyLaunches')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证数据被正确保存到数据库
        $repository = self::getService(DailyLaunchesRepository::class);
        $savedData = $repository->findOneBy(['app' => $app]);
        $this->assertNotNull($savedData);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp('batch');

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDailyLaunches')
            ->with(
                self::isInstanceOf(App::class),
                self::callback(function ($startDate) {
                    return $startDate instanceof CarbonImmutable && '2024-01-01' === $startDate->format('Y-m-d');
                }),
                self::callback(function ($endDate) {
                    return $endDate instanceof CarbonImmutable && '2024-01-31' === $endDate->format('Y-m-d');
                })
            )
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-31',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        // 验证数据被正确保存到数据库
        $repository = self::getService(DailyLaunchesRepository::class);
        $savedData = $repository->findOneBy(['app' => $app]);
        $this->assertNotNull($savedData);
    }

    public function testArgumentStartDate(): void
    {
        $this->createTestApp('startdate');

        $mockResult = $this->createMock(\UmengUappGetLaunchesResult::class);
        $mockResult->method('getLaunchInfo')->willReturn([]);

        $this->dataFetcher->method('fetchDailyLaunches')
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute(['startDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $this->createTestApp('enddate');

        $mockResult = $this->createMock(\UmengUappGetLaunchesResult::class);
        $mockResult->method('getLaunchInfo')->willReturn([]);

        $this->dataFetcher->method('fetchDailyLaunches')
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
        // 只Mock外部API调用,保持内部服务的真实性
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);

        $this->command = self::getService(GetDailyLaunchesCommand::class);
        $this->commandTester = new CommandTester($this->command);
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

    private function createMockResult(): \UmengUappGetLaunchesResult
    {
        $mockCountData = $this->getMockBuilder(\UmengUappCountData::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockCountData->method('getDate')->willReturn('2024-01-01');
        $mockCountData->method('getValue')->willReturn(1000);

        $mockResult = $this->getMockBuilder(\UmengUappGetLaunchesResult::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockResult->method('getLaunchInfo')->willReturn([$mockCountData]);

        return $mockResult;
    }
}
