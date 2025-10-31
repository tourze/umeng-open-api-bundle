<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use UmengOpenApiBundle\Entity\HourlyNewUsers;

/**
 * @extends ServiceEntityRepository<HourlyNewUsers>
 */
#[AsRepository(entityClass: HourlyNewUsers::class)]
class HourlyNewUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HourlyNewUsers::class);
    }

    public function save(HourlyNewUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HourlyNewUsers $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
