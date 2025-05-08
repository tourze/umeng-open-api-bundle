<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\MonthlyNewUsers;

/**
 * @method MonthlyNewUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthlyNewUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthlyNewUsers[]    findAll()
 * @method MonthlyNewUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthlyNewUsersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlyNewUsers::class);
    }
}
