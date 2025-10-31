<?php

namespace UmengOpenApiBundle\Tests\Command;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use UmengOpenApiBundle\Command\GetAppListCommand;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

/**
 * @internal
 */
#[CoversClass(GetAppListCommand::class)]
#[RunTestsInSeparateProcesses]
final class GetAppListCommandTest extends AbstractCommandTestCase
{
    private GetAppListCommand $command;

    private CommandTester $commandTester;

    /** @var UmengDataFetcherInterface&MockObject */
    private MockObject $dataFetcherMock;

    protected function getCommandTester(): CommandTester
    {
        return $this->commandTester;
    }

    protected function onSetUp(): void
    {
        $this->dataFetcherMock = $this->createMock(UmengDataFetcherInterface::class);
        self::getContainer()->set(UmengDataFetcherInterface::class, $this->dataFetcherMock);

        $this->command = self::getService(GetAppListCommand::class);
        $this->commandTester = new CommandTester($this->command);
    }

    public function testExecuteWithNoAccounts(): void
    {
        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithAccountButEmptyApiResult(): void
    {
        $account = $this->createAccount();

        $mockResult = $this->createMock(\UmengUappGetAppListResult::class);
        $mockResult->method('getAppInfos')->willReturn([]);

        $this->dataFetcherMock->expects($this->atLeastOnce())
            ->method('fetchAppList')
            ->with(self::anything(), 1, 100)
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
    }

    public function testExecuteWithValidAppInfo(): void
    {
        $account = $this->createAccount();

        $mockAppInfo = $this->createMock(\UmengUappAppInfoData::class);
        $mockAppInfo->method('getAppkey')->willReturn('test-app-key');
        $mockAppInfo->method('getName')->willReturn('Test App');
        $mockAppInfo->method('getPlatform')->willReturn('android');
        $mockAppInfo->method('getPopular')->willReturn(true);
        $mockAppInfo->method('getUseGameSdk')->willReturn(false);

        $mockResult = $this->createMock(\UmengUappGetAppListResult::class);
        $mockResult->method('getAppInfos')->willReturn([$mockAppInfo]);

        $this->dataFetcherMock->expects($this->atLeastOnce())
            ->method('fetchAppList')
            ->with(self::anything(), 1, 100)
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        $app = $this->getAppRepository()->findOneBy(['appKey' => 'test-app-key']);
        $this->assertNotNull($app);
        $this->assertInstanceOf(App::class, $app);
        $this->assertSame('Test App', $app->getName());
        $this->assertSame('android', $app->getPlatform());
        $this->assertTrue($app->isPopular());
        $this->assertFalse($app->isUseGameSdk());
    }

    public function testExecuteUpdateExistingApp(): void
    {
        $account = $this->createAccount();

        $existingApp = new App();
        $existingApp->setAccount($account);
        $existingApp->setAppKey('existing-app-key');
        $existingApp->setName('Old Name');
        $existingApp->setPlatform('ios');
        $existingApp->setPopular(false);
        $existingApp->setUseGameSdk(false);

        self::getEntityManager()->persist($existingApp);
        self::getEntityManager()->flush();

        $mockAppInfo = $this->createMock(\UmengUappAppInfoData::class);
        $mockAppInfo->method('getAppkey')->willReturn('existing-app-key');
        $mockAppInfo->method('getName')->willReturn('Updated Name');
        $mockAppInfo->method('getPlatform')->willReturn('android');
        $mockAppInfo->method('getPopular')->willReturn(true);
        $mockAppInfo->method('getUseGameSdk')->willReturn(true);

        $mockResult = $this->createMock(\UmengUappGetAppListResult::class);
        $mockResult->method('getAppInfos')->willReturn([$mockAppInfo]);

        $this->dataFetcherMock->expects($this->atLeastOnce())
            ->method('fetchAppList')
            ->with(self::anything(), 1, 100)
            ->willReturn($mockResult)
        ;

        $exitCode = $this->commandTester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        self::getEntityManager()->refresh($existingApp);
        $this->assertSame('Updated Name', $existingApp->getName());
        $this->assertSame('android', $existingApp->getPlatform());
        $this->assertTrue($existingApp->isPopular());
        $this->assertTrue($existingApp->isUseGameSdk());
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

    private function getAppRepository(): AppRepository
    {
        return self::getService(AppRepository::class);
    }
}
