<?php

namespace App\Repository;

use App\Entity\MessageReceived;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageReceived|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageReceived|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageReceived[]    findAll()
 * @method MessageReceived[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageReceivedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageReceived::class);
    }

    // /**
    //  * @return MessageReceived[] Returns an array of MessageReceived objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageReceived
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
