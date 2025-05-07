<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\ThirtyDayActiveUsers;

/**
 * @method ThirtyDayActiveUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThirtyDayActiveUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThirtyDayActiveUsers[]    findAll()
 * @method ThirtyDayActiveUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThirtyDayActiveUsersRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThirtyDayActiveUsers::class);
    }
}
