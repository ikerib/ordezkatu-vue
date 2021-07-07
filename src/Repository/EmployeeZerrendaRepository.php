<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\EmployeeZerrenda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * @method EmployeeZerrenda|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeZerrenda|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeZerrenda[]    findAll()
 * @method EmployeeZerrenda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeZerrendaRepository extends SortableRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(EmployeeZerrenda::class));
    }

    public function findJobEmployeeZerrenda ($jobid) {

    }

    public function findOneByEmployeeZerrenda($employeeid, $zerrendaid)
    {
        $qb = $this->createQueryBuilder('ez')
            ->innerJoin('ez.employee','e')
            ->innerJoin('ez.zerrenda', 'z')
            ->andWhere('e.id = :employeeid')->setParameter('employeeid',$employeeid)
            ->andWhere('z.id = :zerrendaid')->setParameter('zerrendaid',$zerrendaid)
            ->orderBy('ez.position')
            ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function findAllZerrendasForEmployee($employeeid)
    {
        $qb = $this->createQueryBuilder('ez')
                   ->innerJoin('ez.employee', 'e')
                   ->andWhere('e.id = :employeeid')->setParameter('employeeid',$employeeid)
        ;
        return $qb->getQuery()->getResult();
    }

    public function findAllEmployeesFromZerrenda($zerrendaid)
    {
        $qb = $this->createQueryBuilder('ez')
                   ->innerJoin('ez.zerrenda', 'z')
                   ->andWhere('z.id = :zerrendaid')->setParameter('zerrendaid',$zerrendaid)
                    ->orderBy('ez.position')
        ;
        return $qb->getQuery()->getResult();
    }

    public function findPosition($employeeid, $zerrendaid) {
        $qb = $this->createQueryBuilder( 'ez' )
                   ->innerJoin( 'ez.employee', 'e' )
                   ->innerJoin( 'ez.zerrenda', 'z' )
                   ->andWhere( 'e.id=:employeeid' )->setParameter( 'employeeid', $employeeid )
                   ->andWhere('z.id=:zerrendaid')->setParameter('zerrendaid', $zerrendaid)
        ;

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch ( NonUniqueResultException $e ) {
            return null;
        }
    }

    public function getMaxPositionZerrenda($zerrendaid) {
        $qb = $this->createQueryBuilder('ez')
                    ->innerJoin('ez.zerrenda', 'z')
                    ->andWhere('z.id = :zerrendaid')->setParameter('zerrendaid',$zerrendaid)
                    ->groupBy('ez.zerrenda')
                    ->select('MAX(ez.position) as max')
        ;

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
            return '0';
        } catch (NonUniqueResultException $e) {
            return '0';
        }
    }
}
