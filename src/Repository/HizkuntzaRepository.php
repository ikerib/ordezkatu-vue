<?php

namespace App\Repository;

use App\Entity\Hizkuntza;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Hizkuntza|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hizkuntza|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hizkuntza[]    findAll()
 * @method Hizkuntza[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HizkuntzaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hizkuntza::class);
    }

    // /**
    //  * @return Hizkuntza[] Returns an array of Hizkuntza objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hizkuntza
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
