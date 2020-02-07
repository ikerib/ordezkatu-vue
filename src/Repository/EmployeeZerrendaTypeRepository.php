<?php

namespace App\Repository;

use App\Entity\EmployeeZerrendaType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EmployeeZerrendaType|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeZerrendaType|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeZerrendaType[]    findAll()
 * @method EmployeeZerrendaType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeZerrendaTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeZerrendaType::class);
    }

    public function getAllForEmployee($employeeid)
    {
        $qb = $this->createQueryBuilder('ezt')
                    ->innerJoin('ezt.employee', 'e')
                    ->andWhere('e.id = :employeeid')->setParameter('employeeid', $employeeid)
                    ->orderBy('ezt.id', 'desc')
        ;
        return $qb->getQuery()->getResult();
    }

    public function getEmployeeZerrenda($employeeid,$zerrendaid)
    {
        $qb = $this->createQueryBuilder( 'ezt' )
                   ->leftJoin( 'ezt.employee', 'e' )
                   ->leftJoin( 'ezt.zerrenda', 'z' )
                   ->andWhere( 'e.id=:employeeid' )->setParameter( 'employeeid', $employeeid )
                   ->andWhere( 'z.id=:zerrendaid' )->setParameter( 'zerrendaid', $zerrendaid )
        ;

        $qb->getQuery()->getResult();
    }

    // /**
    //  * @return EmployeeZerrendaType[] Returns an array of EmployeeZerrendaType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmployeeZerrendaType
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
