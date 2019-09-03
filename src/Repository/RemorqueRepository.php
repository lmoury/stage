<?php

namespace App\Repository;

use App\Entity\Remorque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Remorque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Remorque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Remorque[]    findAll()
 * @method Remorque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemorqueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Remorque::class);
    }

     /**
    * @return Remorque[] Returns an array of Remorque objects
    */
    public function getRemorques()
    {
        return $this->createQueryBuilder('r')
            ->addSelect('r', 't')
            ->leftJoin('r.type', 't')
            ->addSelect('r', 'o')
            ->leftJoin('r.operation', 'o')
            ->addSelect('o', 'p')
            ->leftJoin('o.parking', 'p')
            ->addSelect('o', 'q')
            ->leftJoin('o.quai', 'q')
            ->leftJoin('o.planning', 'pl')
            ->addSelect('o', 'pl')
            ->leftJoin('o.traction', 'tr')
            ->addSelect('o', 'tr')
            ->leftJoin('tr.quai', 'qu')
            ->addSelect('tr', 'qu')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
   * @return Remorque[] Returns an array of Remorque objects
   */
   public function getRemorquesParking()
   {
       return $this->createQueryBuilder('r')
           ->addSelect('r', 't')
           ->leftJoin('r.type', 't')
           ->addSelect('r', 'o')
           ->leftJoin('r.operation', 'o')
           ->addSelect('o', 'p')
           ->leftJoin('o.parking', 'p')
           ->addSelect('o', 'q')
           ->leftJoin('o.quai', 'q')
           ->leftJoin('o.traction', 'tr')
           ->addSelect('o', 'tr')
           ->leftJoin('o.planning', 'pl')
           ->addSelect('o', 'pl')
           ->andWhere('o.traction is null')
           ->andWhere('o.planning is null')
           ->andWhere('r.maintenance = false')
           ->orderBy('r.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }


   /**
  * @return Remorque[] Returns an array of Remorque objects
  */
  public function getArrivages()
  {
      return $this->createQueryBuilder('r')
          ->addSelect('r', 't')
          ->leftJoin('r.type', 't')
          ->addSelect('r', 'o')
          ->leftJoin('r.operation', 'o')
          ->addSelect('o', 'p')
          ->leftJoin('o.parking', 'p')
          ->addSelect('o', 'q')
          ->leftJoin('o.quai', 'q')
          ->leftJoin('o.traction', 'tr')
          ->addSelect('o', 'tr')
          ->leftJoin('o.planning', 'pl')
          ->addSelect('o', 'pl')
          ->andWhere('o.quai is not null')
          ->andWhere('o.traction is null')
          ->andWhere('o.planning is null')
          ->andWhere('r.maintenance = false')
          ->orderBy('r.id', 'ASC')
          ->getQuery()
          ->getResult()
      ;
  }

    /*
    public function findOneBySomeField($value): ?Remorque
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
