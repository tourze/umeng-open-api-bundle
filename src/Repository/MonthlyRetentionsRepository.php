<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\MonthlyRetentions;

/**
 * @extends ServiceEntityRepository<MonthlyRetentions>
 */
#[AsRepository(entityClass: MonthlyRetentions::class)]
class MonthlyRetentionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlyRetentions::class);
    }

    public function save(MonthlyRetentions $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MonthlyRetentions $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
