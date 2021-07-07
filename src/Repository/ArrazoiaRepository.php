<?php

namespace App\Repository;

use App\Entity\Arrazoia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Arrazoia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arrazoia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arrazoia[]    findAll()
 * @method Arrazoia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArrazoiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arrazoia::class);
    }

    // /**
    //  * @return Arrazoia[] Returns an array of Arrazoia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Arrazoia
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
