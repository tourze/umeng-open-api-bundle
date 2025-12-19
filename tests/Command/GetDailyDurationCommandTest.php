<?php

namespace UmengOpenApiBundle\Tests\Command;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetDailyDurationCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetDailyDurationCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetDailyDurationCommandTest extends AbstractCommandTestCase
{
    private GetDailyDurationCommand $command;

    private CommandTester $commandTester;

    private UmengDataFetcherInterface&MockObject $dataFetcher;

    public function testExecuteWithoutArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDurationData')
            ->with(self::isInstanceOf(App::class))
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithBothArgumentsShouldSucceed(): void
    {
        $app = $this->createTestApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDurationData')
            ->with(self::isInstanceOf(App::class))
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([
            'startDate' => '2024-01-01',
            'endDate' => '2024-01-02',
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentStartDate(): void
    {
        $app = $this->createTestApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDurationData')
            ->with(self::isInstanceOf(App::class))
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute(['startDate' => '2024-01-01']);
        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testArgumentEndDate(): void
    {
        $app = $this->createTestApp();

        $mockResult = $this->createMockResult();
        $this->dataFetcher
            ->expects($this->atLeastOnce())
            ->method('fetchDurationData')
            ->with(self::isInstanceOf(App::class))
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
        $this->dataFetcher = $this->createMock(UmengDataFetcherInterface::class);

        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcher);

        $this->command = self::getService(GetDailyDurationCommand::class);
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

    private function createMockResult(): \UmengUappGetDurationsResult
    {
        $mockDurationInfo = $this->getMockBuilder(\UmengUappDurationInfo::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockDurationInfo->method('getName')->willReturn('0-10s');
        $mockDurationInfo->method('getValue')->willReturn(100);
        $mockDurationInfo->method('getPercent')->willReturn(25.5);

        $mockResult = $this->getMockBuilder(\UmengUappGetDurationsResult::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockResult->method('getDurationInfos')->willReturn([$mockDurationInfo]);

        return $mockResult;
    }
}
