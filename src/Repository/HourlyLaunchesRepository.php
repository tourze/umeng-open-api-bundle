<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\HourlyLaunches;

/**
 * @method HourlyLaunches|null find($id, $lockMode = null, $lockVersion = null)
 * @method HourlyLaunches|null findOneBy(array $criteria, array $orderBy = null)
 * @method HourlyLaunches[]    findAll()
 * @method HourlyLaunches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HourlyLaunchesRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HourlyLaunches::class);
    }
}
