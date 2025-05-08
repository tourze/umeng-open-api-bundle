<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\HourlyNewUsers;

/**
 * @method HourlyNewUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method HourlyNewUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method HourlyNewUsers[]    findAll()
 * @method HourlyNewUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HourlyNewUsersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HourlyNewUsers::class);
    }
}
