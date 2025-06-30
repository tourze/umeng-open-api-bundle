<?php

namespace UmengOpenApiBundle\Tests\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use UmengOpenApiBundle\Command\GetDailyDurationCommand;
use Doctrine\ORM\EntityManagerInterface;
use UmengOpenApiBundle\Repository\AccountRepository;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyDurationRepository;

class GetDailyDurationCommandTest extends TestCase
{
    public function testConfigure(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $durationRepository = $this->createMock(DailyDurationRepository::class);
        $appRepository = $this->createMock(AppRepository::class);
        
        $command = new GetDailyDurationCommand(
            $durationRepository,
            $appRepository,
            $entityManager
        );
        
        $this->assertNotNull($command->getName());
        $this->assertNotNull($command->getDescription());
    }

    public function testExecute(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $durationRepository = $this->createMock(DailyDurationRepository::class);
        $appRepository = $this->createMock(AppRepository::class);
        
        // 模拟返回空数组，避免执行实际的 API 调用
        $appRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([]);
        
        $command = new GetDailyDurationCommand(
            $durationRepository,
            $appRepository,
            $entityManager
        );
        
        $application = new Application();
        $application->add($command);
        
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }
}