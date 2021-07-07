<?php

namespace App\Repository;

use App\Entity\JobZerrendaEmployee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobZerrendaEmployee|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobZerrendaEmployee|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobZerrendaEmployee[]    findAll()
 * @method JobZerrendaEmployee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobZerrendaEmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobZerrendaEmployee::class);
    }

    // /**
    //  * @return JobZerrendaEmployee[] Returns an array of JobZerrendaEmployee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobZerrendaEmployee
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
