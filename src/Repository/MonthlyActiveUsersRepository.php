<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\MonthlyActiveUsers;

/**
 * @method MonthlyActiveUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthlyActiveUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthlyActiveUsers[]    findAll()
 * @method MonthlyActiveUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthlyActiveUsersRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlyActiveUsers::class);
    }
}
