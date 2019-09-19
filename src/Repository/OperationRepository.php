<?php

namespace App\Repository;

use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    /**
    * @return Operation Return one Operation objects
    */
    public function getSearchRemorque($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.remorque = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
    * @return Operation Return one Operation objects
    */
    public function getDeleteOperationPlanning()
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.planning is not null')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Operation Return one Operation objects
    */
    public function getDeleteOperationTraction()
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.traction is not null')
            ->andWhere('o.parking is null')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Operation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
