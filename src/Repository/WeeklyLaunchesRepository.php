<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\WeeklyLaunches;

/**
 * @method WeeklyLaunches|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeeklyLaunches|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeeklyLaunches[]    findAll()
 * @method WeeklyLaunches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeeklyLaunchesRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeeklyLaunches::class);
    }
}
