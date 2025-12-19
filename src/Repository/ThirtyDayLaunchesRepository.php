<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\ThirtyDayLaunches;

/**
 * @extends ServiceEntityRepository<ThirtyDayLaunches>
 */
#[AsRepository(entityClass: ThirtyDayLaunches::class)]
final class ThirtyDayLaunchesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThirtyDayLaunches::class);
    }

    public function save(ThirtyDayLaunches $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ThirtyDayLaunches $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?ThirtyDayLaunches
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
