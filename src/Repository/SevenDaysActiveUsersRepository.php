<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\SevenDaysActiveUsers;

/**
 * @extends ServiceEntityRepository<SevenDaysActiveUsers>
 */
#[AsRepository(entityClass: SevenDaysActiveUsers::class)]
class SevenDaysActiveUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SevenDaysActiveUsers::class);
    }

    public function save(SevenDaysActiveUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SevenDaysActiveUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?SevenDaysActiveUsers
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
