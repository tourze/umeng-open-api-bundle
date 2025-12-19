<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\SevenDaysLaunches;

/**
 * @extends ServiceEntityRepository<SevenDaysLaunches>
 */
#[AsRepository(entityClass: SevenDaysLaunches::class)]
final class SevenDaysLaunchesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SevenDaysLaunches::class);
    }

    public function save(SevenDaysLaunches $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SevenDaysLaunches $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?SevenDaysLaunches
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
