<?php

namespace App\Repository;

use App\Entity\Notifycation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Notifycation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notifycation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notifycation[]    findAll()
 * @method Notifycation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotifycationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notifycation::class);
    }

    // /**
    //  * @return Notifycation[] Returns an array of Notifycation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notifycation
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
