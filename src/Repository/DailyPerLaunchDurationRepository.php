<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;

/**
 * @method DailyPerLaunchDuration|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyPerLaunchDuration|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyPerLaunchDuration[]    findAll()
 * @method DailyPerLaunchDuration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyPerLaunchDurationRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyPerLaunchDuration::class);
    }
}
