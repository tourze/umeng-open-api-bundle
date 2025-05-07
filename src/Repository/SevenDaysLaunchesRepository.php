<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\SevenDaysLaunches;

/**
 * @method SevenDaysLaunches|null find($id, $lockMode = null, $lockVersion = null)
 * @method SevenDaysLaunches|null findOneBy(array $criteria, array $orderBy = null)
 * @method SevenDaysLaunches[]    findAll()
 * @method SevenDaysLaunches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SevenDaysLaunchesRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SevenDaysLaunches::class);
    }
}
