<?php

namespace App\Repository;

use App\Entity\UnitsOwned;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnitsOwned|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnitsOwned|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnitsOwned[]    findAll()
 * @method UnitsOwned[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitsOwnedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnitsOwned::class);
    }

    // /**
    //  * @return UnitsOwned[] Returns an array of UnitsOwned objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnitsOwned
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
