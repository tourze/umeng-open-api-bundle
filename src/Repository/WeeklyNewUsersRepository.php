<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\WeeklyNewUsers;

/**
 * @method WeeklyNewUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeeklyNewUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeeklyNewUsers[]    findAll()
 * @method WeeklyNewUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeeklyNewUsersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeeklyNewUsers::class);
    }
}
