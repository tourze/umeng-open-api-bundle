<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\DailyLaunches;

/**
 * @method DailyLaunches|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyLaunches|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyLaunches[]    findAll()
 * @method DailyLaunches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyLaunchesRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyLaunches::class);
    }
}
