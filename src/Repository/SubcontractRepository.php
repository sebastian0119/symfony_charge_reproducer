<?php

namespace App\Repository;

use App\Entity\Subcontract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subcontract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subcontract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subcontract[]    findAll()
 * @method Subcontract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcontractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subcontract::class);
    }

    public function getAllSubcontracts($currentPage = 1, $subcontractDescription = '')
    {
        // query
        $query = $this->createQueryBuilder('s');

        if (!empty($subcontractDescription)) {
            $query->where('s.description LIKE :subcontractDescription')
                ->setParameter('subcontractDescription', '%' . $subcontractDescription . '%');
        }

        // returns just the query, not the result
        return $query
            ->orderBy('s.description', 'ASC');

        // returns an array of Company objects
        //return $query->getResult();
    }

    public function findTotalByContract($contract)
    {
        // query
        $qb = $this->createQueryBuilder('s')
            ->select('s.id, s.description, s.amount')
            ->leftJoin('s.charges', 'ch')
            ->addSelect('SUM(ch.factor * ch.amount) as chargeTotal')
            ->addGroupBy('ch.subcontract')
            ->join('s.currency', 'cu')
            ->addSelect('cu.symbol')
            ->join('s.company', 'co')
            ->addSelect('co.name as companyName')
            ->where('s.contract = :contractId')
            ->setParameter('contractId', $contract);
        // Show the generated DQL string
        // I got that from https://symfonycasts.com/screencast/doctrine-queries/query-builder
        //var_dump($query->getDQL());
        // Show the query result
        //var_dump($qb->getQuery()->getScalarResult());
        // Do not just use getResult(); the output will not be readable
        //die;
        $query = $qb->getQuery();
        return $query->getScalarResult();
    }

    public function findCompanySubcontractsByProject($project, $company)
    {
        // query
        $qb = $this->createQueryBuilder('s');
        $qb->innerJoin('s.contract', 'c')
            ->innerJoin('c.project', 'p')
            ->where('c.project = :project')
            ->andWhere('s.company = :company')
            ->setParameter('project', $project)
            ->setParameter('company', $company)
            ->orderBy('s.description', 'ASC');
        //var_dump($qb->getDQL());
        // Show the query result
        //var_dump($qb->getQuery()->getScalarResult());
        // Do not just use getResult(); the output will not be readable
        //die;
        $query = $qb->getQuery();

        return $query->getResult();
    }

    // /**
    //  * @return Subcontract[] Returns an array of Subcontract objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subcontract
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
