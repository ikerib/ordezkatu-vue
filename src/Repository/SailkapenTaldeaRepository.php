<?php

namespace App\Repository;

use App\Entity\SailkapenTaldea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SailkapenTaldea|null find($id, $lockMode = null, $lockVersion = null)
 * @method SailkapenTaldea|null findOneBy(array $criteria, array $orderBy = null)
 * @method SailkapenTaldea[]    findAll()
 * @method SailkapenTaldea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SailkapenTaldeaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SailkapenTaldea::class);
    }

    // /**
    //  * @return SailkapenTaldea[] Returns an array of SailkapenTaldea objects
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
    public function findOneBySomeField($value): ?SailkapenTaldea
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
