<?php

namespace App\Repository;

use App\Entity\Calls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Calls|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calls|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calls[]    findAll()
 * @method Calls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calls::class);
    }

    public function getCallsByEmployeeZerrenda($employeezerrendaid)
    {
        return $this->createQueryBuilder('c')
                    ->innerJoin('c.employeezerrenda', 'ez')
                    ->andWhere('ez.zerrenda = :zerrendaid')->setParameter('zerrendaid', $employeezerrendaid)
                    ->getQuery()
                    ->getResult()
            ;
    }
    // /**
    //  * @return Calls[] Returns an array of Calls objects
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
    public function findOneBySomeField($value): ?Calls
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
