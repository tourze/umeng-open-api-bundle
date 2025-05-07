<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\DailyData;

/**
 * @method DailyData|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyData|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyData[]    findAll()
 * @method DailyData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyDataRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyData::class);
    }
}
