<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\DailyDuration;

/**
 * @method DailyDuration|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyDuration|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyDuration[]    findAll()
 * @method DailyDuration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyDurationRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyDuration::class);
    }
}
