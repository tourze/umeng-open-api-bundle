<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\HourlyActiveUsers;

/**
 * @method HourlyActiveUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method HourlyActiveUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method HourlyActiveUsers[]    findAll()
 * @method HourlyActiveUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HourlyActiveUsersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HourlyActiveUsers::class);
    }
}
