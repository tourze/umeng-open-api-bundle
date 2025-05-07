<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\DailyChannelData;

/**
 * @method DailyChannelData|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyChannelData|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyChannelData[]    findAll()
 * @method DailyChannelData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyChannelDataRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyChannelData::class);
    }
}
