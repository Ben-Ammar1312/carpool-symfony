<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // Méthode pour obtenir les messages par ID d'annonce (ride)
    public function findByAnnonceIdOrderByTimestampAsc(int $rideId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.annonce = :rideId')
            ->setParameter('rideId', $rideId)
            ->orderBy('m.timestamp', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Méthode pour obtenir les messages par ID de chat
    public function findByChatIdOrderByTimestampAsc(int $chatId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.chat = :chatId')
            ->setParameter('chatId', $chatId)
            ->orderBy('m.timestamp', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Compter les messages non lus par un destinataire
    public function countByReceiverIdAndIsReadFalse(int $receiverId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.receiver = :receiverId')
            ->andWhere('m.isRead = false')
            ->setParameter('receiverId', $receiverId)
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Obtenir les messages non lus d'un utilisateur dans un chat donné
    public function findByChatIdAndReceiverIdAndIsReadFalse(int $chatId, int $receiverId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.chat = :chatId')
            ->andWhere('m.receiver = :receiverId')
            ->andWhere('m.isRead = false')
            ->setParameter('chatId', $chatId)
            ->setParameter('receiverId', $receiverId)
            ->getQuery()
            ->getResult();
    }
}
