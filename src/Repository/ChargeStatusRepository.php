<?php

namespace App\Repository;

use App\Entity\ChargeStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChargeStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChargeStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChargeStatus[]    findAll()
 * @method ChargeStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargeStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChargeStatus::class);
    }

    // /**
    //  * @return ChargeStatus[] Returns an array of ChargeStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChargeStatus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
