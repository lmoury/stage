<?php

namespace App\Repository;

use App\Entity\Quai;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Quai|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quai|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quai[]    findAll()
 * @method Quai[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuaiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Quai::class);
    }

    /**
    * @return Quai[] Returns an array of Quai objects
    */
    public function getQuais()
    {
        return $this->createQueryBuilder('q')
            ->addSelect('q', 'o')
            ->leftJoin('q.operation', 'o')
            ->addSelect('o', 'r')
            ->leftJoin('o.remorque', 'r')
            ->addSelect('r', 't')
            ->leftJoin('r.type', 't')
            ->addSelect('r', 'op')
            ->leftJoin('r.operation', 'op')
            ->orderBy('q.numero', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Quai
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
