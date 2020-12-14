<?php

namespace App\Repository;

use App\Entity\NextCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NextCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method NextCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method NextCategory[]    findAll()
 * @method NextCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NextCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NextCategory::class);
    }

    // /**
    //  * @return NextCategory[] Returns an array of NextCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NextCategory
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
