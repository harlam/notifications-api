<?php

namespace App\Repository;

use App\Entity\NotificationChannel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotificationChannel|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationChannel|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationChannel[]    findAll()
 * @method NotificationChannel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationChannelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationChannel::class);
    }

    /**
     * @throws ORMException
     */
    public function store(NotificationChannel $notificationChannel): void
    {
        $this->getEntityManager()->persist($notificationChannel);
        $this->getEntityManager()->flush();
    }

    // /**
    //  * @return NotificationChannel[] Returns an array of NotificationChannel objects
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
    public function findOneBySomeField($value): ?NotificationChannel
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
