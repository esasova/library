<?php

namespace App\Repository;

use App\Entity\Reserved;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reserved|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserved|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserved[]    findAll()
 * @method Reserved[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserved::class);
    }

    // /**
    //  * @return Reserved[] Returns an array of Reserved objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reserved
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
