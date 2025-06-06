<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\SevenDaysNewUsers;

/**
 * @method SevenDaysNewUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method SevenDaysNewUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method SevenDaysNewUsers[]    findAll()
 * @method SevenDaysNewUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SevenDaysNewUsersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SevenDaysNewUsers::class);
    }
}
