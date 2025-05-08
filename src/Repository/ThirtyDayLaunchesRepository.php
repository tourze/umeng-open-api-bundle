<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\ThirtyDayLaunches;

/**
 * @method ThirtyDayLaunches|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThirtyDayLaunches|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThirtyDayLaunches[]    findAll()
 * @method ThirtyDayLaunches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThirtyDayLaunchesRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThirtyDayLaunches::class);
    }
}
