<?php

namespace App\Repository;

use App\Entity\CompanyLegaltype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyLegaltype|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyLegaltype|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyLegaltype[]    findAll()
 * @method CompanyLegaltype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyLegaltypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyLegaltype::class);
    }

    // /**
    //  * @return CompanyLegaltype[] Returns an array of CompanyLegaltype objects
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
    public function findOneBySomeField($value): ?CompanyLegaltype
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
