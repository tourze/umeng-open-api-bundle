<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\WeeklyActiveUsers;

/**
 * @method WeeklyActiveUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeeklyActiveUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeeklyActiveUsers[]    findAll()
 * @method WeeklyActiveUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeeklyActiveUsersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeeklyActiveUsers::class);
    }
}
