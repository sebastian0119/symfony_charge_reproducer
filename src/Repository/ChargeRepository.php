<?php

namespace App\Repository;

use App\Entity\Charge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Charge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Charge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Charge[]    findAll()
 * @method Charge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Charge::class);
    }

    public function paginateCharges($searchString = '', $searchStatus = 0, $currentPage = 1)
    {
        // query
        $query = $this->createQueryBuilder('c');

        if (!empty($searchString)) {
            $query->innerJoin('c.company', 'co')
                ->where('c.id LIKE :searchString')
                ->orWhere('co.name LIKE :searchString')
                ->orWhere('co.alternate LIKE :searchString')
                ->setParameter('searchString', '%' . $searchString . '%');
        }

        if ($searchStatus) {
            $query->andWhere('c.status = :searchStatus')
                ->setParameter('searchStatus', $searchStatus);
        }

        // returns just the query, not the result
        return $query
            ->orderBy('c.id', 'ASC');

        // returns an array of Company objects
        //return $query->getResult();
    }

    // /**
    //  * @return Charge[] Returns an array of Charge objects
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
    public function findOneBySomeField($value): ?Charge
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
