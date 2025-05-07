<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\MonthlyLaunches;

/**
 * @method MonthlyLaunches|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthlyLaunches|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthlyLaunches[]    findAll()
 * @method MonthlyLaunches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthlyLaunchesRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlyLaunches::class);
    }
}
