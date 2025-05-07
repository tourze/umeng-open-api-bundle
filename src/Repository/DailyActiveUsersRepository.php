<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\DailyActiveUsers;

/**
 * @method DailyActiveUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyActiveUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyActiveUsers[]    findAll()
 * @method DailyActiveUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyActiveUsersRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyActiveUsers::class);
    }
}
