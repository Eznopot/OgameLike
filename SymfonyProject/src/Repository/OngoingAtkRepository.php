<?php

namespace App\Repository;

use App\Entity\OngoingAtk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OngoingAtk|null find($id, $lockMode = null, $lockVersion = null)
 * @method OngoingAtk|null findOneBy(array $criteria, array $orderBy = null)
 * @method OngoingAtk[]    findAll()
 * @method OngoingAtk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OngoingAtkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OngoingAtk::class);
    }

    // /**
    //  * @return OngoingAtk[] Returns an array of OngoingAtk objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OngoingAtk
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
