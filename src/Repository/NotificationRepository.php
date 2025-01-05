<?php

namespace App\Repository;

use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    // Trouver toutes les notifications pour un utilisateur par son ID
    public function findAllByUserId(int $userId)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    // Trouver les notifications par ID utilisateur et triées par timestamp décroissant
    public function findByUserIdOrderByTimestampDesc(int $userId)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('n.timestamp', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // Trouver les notifications non lues pour un utilisateur, triées par timestamp décroissant
    public function findUnreadByUserIdOrderByTimestampDesc(int $userId)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.user = :userId')
            ->andWhere('n.isRead = false')
            ->setParameter('userId', $userId)
            ->orderBy('n.timestamp', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
