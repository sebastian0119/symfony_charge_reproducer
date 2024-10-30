<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function paginateProjects($searchString = '', $currentPage = 1)
    {
        // query
        $query = $this->createQueryBuilder('p');

        if (!empty($searchString)) {
            $query->innerJoin('p.company', 'c')
                ->where('p.name LIKE :searchString')
                ->orWhere('p.code LIKE :searchString')
                ->orWhere('c.name LIKE :searchString')
                ->orWhere('c.alternate LIKE :searchString')
                ->setParameter('searchString', '%' . $searchString . '%');
        }

        // returns just the query, not the result
        return $query
            ->orderBy('p.name', 'ASC');

        // returns an array of Company objects
        //return $query->getResult();
    }

    public function findProjectSubcontractsByCompany($company)
    {
        // query
        $qb = $this->createQueryBuilder('p');
        $qb->innerJoin('p.contracts', 'c')
            ->innerJoin('c.subcontracts', 's')
            ->where('s.company = :company')
            ->setParameter('company', $company)
            ->orderBy('p.name', 'ASC');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
