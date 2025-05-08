<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\ThirtyDayNewUsers;

/**
 * @method ThirtyDayNewUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThirtyDayNewUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThirtyDayNewUsers[]    findAll()
 * @method ThirtyDayNewUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThirtyDayNewUsersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThirtyDayNewUsers::class);
    }
}
