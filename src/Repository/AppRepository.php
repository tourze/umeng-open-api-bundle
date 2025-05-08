<?php

namespace UmengOpenApiBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use UmengOpenApiBundle\Entity\App;

/**
 * @method App|null find($id, $lockMode = null, $lockVersion = null)
 * @method App|null findOneBy(array $criteria, array $orderBy = null)
 * @method App[]    findAll()
 * @method App[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, App::class);
    }
}
