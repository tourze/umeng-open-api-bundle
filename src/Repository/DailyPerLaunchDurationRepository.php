<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;

/**
 * @extends ServiceEntityRepository<DailyPerLaunchDuration>
 */
#[AsRepository(entityClass: DailyPerLaunchDuration::class)]
final class DailyPerLaunchDurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyPerLaunchDuration::class);
    }

    public function save(DailyPerLaunchDuration $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DailyPerLaunchDuration $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?DailyPerLaunchDuration
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
