<?php

namespace App\Repository;

use App\Entity\JobDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobDetail[]    findAll()
 * @method JobDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobDetail::class);
    }

    public function updatePosition($jobid, $position) {
        $q = $this->createQueryBuilder( 'j' )
                  ->update()
                  ->set( 'j.position', 'j.position - 1' )
                  ->andWhere('j.job=:jobid')->setParameter('jobid', $jobid)
                 ->andWhere('j.position > :pos')->setParameter('pos', $position)
        ;
        dump( $q->getQuery()->getSQL() );
        $q->getQuery()->execute();
    }
    // /**
    //  * @return JobDetail[] Returns an array of JobDetail objects
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
    public function findOneBySomeField($value): ?JobDetail
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
