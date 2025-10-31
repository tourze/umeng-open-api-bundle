<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\SevenDaysNewUsers;

/**
 * @extends ServiceEntityRepository<SevenDaysNewUsers>
 */
#[AsRepository(entityClass: SevenDaysNewUsers::class)]
class SevenDaysNewUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SevenDaysNewUsers::class);
    }

    public function save(SevenDaysNewUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SevenDaysNewUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?SevenDaysNewUsers
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
