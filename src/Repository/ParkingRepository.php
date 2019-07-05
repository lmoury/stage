<?php

namespace App\Repository;

use App\Entity\Parking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Parking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parking[]    findAll()
 * @method Parking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParkingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Parking::class);
    }

    /**
    * @return Parking[] Returns an array of Parking objects
    */
    public function getParkings()
    {
        return $this->createQueryBuilder('p')
            ->addSelect('p', 'o')
            ->leftJoin('p.operations', 'o')
            ->addSelect('o', 'r')
            ->leftJoin('o.remorque', 'r')
            ->addSelect('r', 't')
            ->leftJoin('r.type', 't')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Parking
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
