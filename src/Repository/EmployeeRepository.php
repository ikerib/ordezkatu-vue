<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Gedmo\Sortable\Entity\Repository\SortableRepository;


class EmployeeRepository extends SortableRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Employee::class));
    }

    public function finyOneByNan($nan)
    {
        try {
            return $this->createQueryBuilder('e')
                        ->andWhere('e.nan=:nan')->setParameter('nan', $nan)
                        ->getQuery()
                        ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function findAllWithinList($zerrendaid)
    {
        return $this->createQueryBuilder('e')
                    ->innerJoin('e.employeeZerrenda', 'ez')
                    ->andWhere('ez.zerrenda = :zerrendaid')
                    ->setParameter('zerrendaid', $zerrendaid)
                    ->getQuery()
                    ->getResult()
            ;
    }

    public function hangleSearch($query)
    {
        $qb = $this->createQueryBuilder('e')
                   ->orWhere('e.name LIKE :query')->setParameter('query', '%'.$query.'%')
                   ->orWhere('e.abizena1 LIKE :query')->setParameter('query', '%'.$query.'%')
                   ->orWhere('e.abizena2 LIKE :query')->setParameter('query', '%'.$query.'%')
                   ->orWhere('e.nan LIKE :query')->setParameter('query', '%'.$query.'%')
                   ->orWhere('e.telefono LIKE :query')->setParameter('query', '%'.$query.'%')
        ;

        return $qb->getQuery()->getResult();
    }
}
