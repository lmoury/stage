<?php

namespace App\Repository;

use App\Entity\RemorqueType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeRemorque|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeRemorque|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeRemorque[]    findAll()
 * @method TypeRemorque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemorqueTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RemorqueType::class);
    }

    // /**
    //  * @return TypeRemorque[] Returns an array of TypeRemorque objects
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
    public function findOneBySomeField($value): ?TypeRemorque
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
