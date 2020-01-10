<?php

namespace App\Repository;

use App\Entity\Saila;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Saila|null find($id, $lockMode = null, $lockVersion = null)
 * @method Saila|null findOneBy(array $criteria, array $orderBy = null)
 * @method Saila[]    findAll()
 * @method Saila[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SailaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saila::class);
    }

    // /**
    //  * @return Saila[] Returns an array of Saila objects
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
    public function findOneBySomeField($value): ?Saila
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
