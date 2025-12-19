<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\ThirtyDayNewUsers;

/**
 * @extends ServiceEntityRepository<ThirtyDayNewUsers>
 */
#[AsRepository(entityClass: ThirtyDayNewUsers::class)]
final class ThirtyDayNewUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThirtyDayNewUsers::class);
    }

    public function save(ThirtyDayNewUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ThirtyDayNewUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, string>|null $orderBy
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?ThirtyDayNewUsers
    {
        /** @var ThirtyDayNewUsers|null */
        return parent::findOneBy($criteria, $orderBy);
    }
}
