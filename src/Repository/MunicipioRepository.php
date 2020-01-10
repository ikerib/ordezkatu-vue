<?php

namespace App\Repository;

use App\Entity\Municipio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use mysql_xdevapi\Exception;

/**
 * @method Municipio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Municipio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Municipio[]    findAll()
 * @method Municipio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MunicipioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipio::class);
    }

    public function findAllProvincias()
    {
        $q = $this->createQueryBuilder('m')
            ->select('distinct m.provincia')
            ;

        return $q->getQuery()->getResult();
    }

    public function findAllMunicipiosByProvincia($provincia)
    {
        $q = $this->createQueryBuilder('m')
                ->andWhere('m.provincia = :provincia')->setParameter('provincia', $provincia)
        ;

        return $q->getQuery()->getResult();
    }

    public function findMunicipioByCodPostal($codpostal)
    {
        $q = $this->createQueryBuilder('m')
                  ->andWhere('m.codpostal = :codpostal')->setParameter('codpostal', $codpostal)
        ;

        try {
            return $q->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            new NonUniqueResultException($e->getMessage());
        }
    }
}
