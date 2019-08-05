<?php

namespace App\Repository;

use App\Entity\Traction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Traction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Traction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Traction[]    findAll()
 * @method Traction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TractionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Traction::class);
    }

    // /**
    //  * @return Traction[] Returns an array of Traction objects
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
    public function findOneBySomeField($value): ?Traction
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
