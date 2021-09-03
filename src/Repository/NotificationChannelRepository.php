<?php

namespace App\Repository;

use App\Entity\NotificationChannel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
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

    /**
     * @throws NonUniqueResultException
     */
    public function findByKey(string $key): ?NotificationChannel
    {
        return $this->createQueryBuilder('channel')
            ->andWhere('channel.key = :key')
            ->setParameter('key', $key)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function getByKey(string $key): NotificationChannel
    {
        $result = $this->findByKey($key);

        if (null === $result) {
            throw new EntityNotFoundException();
        }

        return $result;
    }
}
