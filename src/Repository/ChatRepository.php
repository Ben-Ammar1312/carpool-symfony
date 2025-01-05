<?php

namespace App\Repository;

use App\Entity\Chat;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    /**
     * Trouver les chats auxquels un utilisateur participe.
     *
     * @param User $user
     * @return Chat[]
     */
    public function findByParticipantsContaining(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.participants', 'p')
            ->where('p = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouver un chat avec ses participants par l'ID du chat.
     *
     * @param int $chatId
     * @return Chat|null
     */
    public function findChatWithParticipants(int $chatId): ?Chat
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.participants', 'p')
            ->addSelect('p')  // Charge les participants explicitement
            ->where('c.id = :chatId')
            ->setParameter('chatId', $chatId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Trouver un chat par l'ID de l'annonce et vérifier si un utilisateur est participant.
     *
     * @param int $rideId
     * @param User $participant
     * @return Chat|null
     */
    public function findByAnnonce_IdAnnonceAndParticipantsContaining(int $rideId, User $participant): ?Chat
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.participants', 'p')
            ->where('c.annonce = :rideId')
            ->andWhere('p = :participant')
            ->setParameter('rideId', $rideId)
            ->setParameter('participant', $participant)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
