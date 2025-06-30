<?php

namespace UmengOpenApiBundle\Tests\Integration\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;
use UmengOpenApiBundle\Repository\DailyPerLaunchDurationRepository;
use UmengOpenApiBundle\Tests\Integration\IntegrationTestKernel;
use UmengOpenApiBundle\Tests\Integration\Exception\TestSetupException;

class DailyPerLaunchDurationRepositoryTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    private EntityManagerInterface $em;
    private DailyPerLaunchDurationRepository $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        /** @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine */
        $doctrine = $kernel->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        if (!$em instanceof EntityManagerInterface) {
            throw TestSetupException::entityManagerNotFound();
        }
        $this->em = $em;
        /** @var DailyPerLaunchDurationRepository $repository */
        $repository = $kernel->getContainer()->get(DailyPerLaunchDurationRepository::class);
        $this->repository = $repository;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->em->close();
    }

    public function testRepository(): void
    {
        $this->assertInstanceOf(DailyPerLaunchDurationRepository::class, $this->repository);
    }

    public function testFindMethods(): void
    {
        // 测试 findAll 方法
        $results = $this->repository->findAll();
        $this->assertIsArray($results);
        
        // 测试 findBy 方法
        $results = $this->repository->findBy([], null, 10);
        $this->assertIsArray($results);
        
        // 测试 find 方法
        $result = $this->repository->find(1);
        $this->assertNull($result); // 假设没有 ID 为 1 的记录
        
        // 测试 findOneBy 方法
        $result = $this->repository->findOneBy(['id' => 1]);
        $this->assertNull($result); // 假设没有 ID 为 1 的记录
    }
}
