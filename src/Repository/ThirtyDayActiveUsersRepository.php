<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\ThirtyDayActiveUsers;

/**
 * @extends ServiceEntityRepository<ThirtyDayActiveUsers>
 */
#[AsRepository(entityClass: ThirtyDayActiveUsers::class)]
class ThirtyDayActiveUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThirtyDayActiveUsers::class);
    }

    public function save(ThirtyDayActiveUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ThirtyDayActiveUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?ThirtyDayActiveUsers
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
