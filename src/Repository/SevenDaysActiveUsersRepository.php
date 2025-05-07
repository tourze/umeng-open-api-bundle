<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use UmengOpenApiBundle\Entity\SevenDaysActiveUsers;

/**
 * @method SevenDaysActiveUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method SevenDaysActiveUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method SevenDaysActiveUsers[]    findAll()
 * @method SevenDaysActiveUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SevenDaysActiveUsersRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SevenDaysActiveUsers::class);
    }
}
