<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\DailyData;

/**
 * @extends ServiceEntityRepository<DailyData>
 */
#[AsRepository(entityClass: DailyData::class)]
class DailyDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyData::class);
    }

    public function save(DailyData $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DailyData $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?DailyData
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
