<?php

namespace App\Repository;

use App\Entity\TechnologiesOwned;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TechnologiesOwned|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnologiesOwned|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnologiesOwned[]    findAll()
 * @method TechnologiesOwned[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnologiesOwnedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnologiesOwned::class);
    }

    // /**
    //  * @return TechnologiesOwned[] Returns an array of TechnologiesOwned objects
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
    public function findOneBySomeField($value): ?TechnologiesOwned
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
