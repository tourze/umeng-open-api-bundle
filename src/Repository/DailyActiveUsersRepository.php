<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\DailyActiveUsers;

/**
 * @extends ServiceEntityRepository<DailyActiveUsers>
 */
#[AsRepository(entityClass: DailyActiveUsers::class)]
class DailyActiveUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyActiveUsers::class);
    }

    public function save(DailyActiveUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DailyActiveUsers $entity, bool $flush = true): void
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
    public function findOneBy(array $criteria, ?array $orderBy = null): ?DailyActiveUsers
    {
        /** @var DailyActiveUsers|null */
        return parent::findOneBy($criteria, $orderBy);
    }
}
