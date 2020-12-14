<?php

namespace App\Repository;

use App\Entity\GalleryVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GalleryVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryVideo[]    findAll()
 * @method GalleryVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryVideo::class);
    }

    // /**
    //  * @return GalleryVideo[] Returns an array of GalleryVideo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GalleryVideo
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
