<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\MonthlyRetentions;

/**
 * @method MonthlyRetentions|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthlyRetentions|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthlyRetentions[]    findAll()
 * @method MonthlyRetentions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthlyRetentionsRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlyRetentions::class);
    }
}
