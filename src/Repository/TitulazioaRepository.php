<?php

namespace App\Repository;

use App\Entity\Titulazioa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Titulazioa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Titulazioa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Titulazioa[]    findAll()
 * @method Titulazioa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitulazioaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Titulazioa::class);
    }

    // /**
    //  * @return Titulazioa[] Returns an array of Titulazioa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Titulazioa
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
