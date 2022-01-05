<?php

namespace App\Repository;

use App\Entity\BatimentOwned;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BatimentOwned|null find($id, $lockMode = null, $lockVersion = null)
 * @method BatimentOwned|null findOneBy(array $criteria, array $orderBy = null)
 * @method BatimentOwned[]    findAll()
 * @method BatimentOwned[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BatimentOwnedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BatimentOwned::class);
    }

    // /**
    //  * @return BatimentOwned[] Returns an array of BatimentOwned objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BatimentOwned
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
