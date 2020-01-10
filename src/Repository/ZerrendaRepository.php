<?php

namespace App\Repository;

use App\Entity\Zerrenda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Zerrenda|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zerrenda|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zerrenda[]    findAll()
 * @method Zerrenda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZerrendaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zerrenda::class);
    }


    public function getAllZerrendas(): \Doctrine\ORM\QueryBuilder
    {
        $q = $this->createQueryBuilder('z')
                  ->orderBy('z.name', 'ASC')
        ;

        return $q;
    }

    public function getAllZerrendasForUser($employeeid): \Doctrine\ORM\QueryBuilder
    {
        $q = $this->createQueryBuilder('z')
                ->innerJoin('z.employeeZerrenda', 'ze')
                ->innerJoin('ze.employee', 'e')
                ->andWhere('e.id = :employeeid')->setParameter('employeeid', $employeeid)
                  ->orderBy('z.name', 'ASC')
        ;

        return $q;
    }
    // /**
    //  * @return Zerrenda[] Returns an array of Zerrenda objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Zerrenda
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
