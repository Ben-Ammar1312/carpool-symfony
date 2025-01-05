<?php

namespace App\Repository;

use App\Entity\RefreshToken;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class RefreshTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    // Trouver un RefreshToken par son token
    public function findByToken(string $token)
    {
        return $this->createQueryBuilder('rt')
            ->andWhere('rt.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // Trouver un RefreshToken par un utilisateur
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('rt')
            ->andWhere('rt.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // Supprimer les RefreshTokens dont la date d'expiration est avant la date actuelle
    public function deleteByExpiryDateBefore(\DateTimeInterface $now)
    {
        return $this->createQueryBuilder('rt')
            ->delete()
            ->where('rt.expiryDate < :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->execute();
    }

    // Supprimer tous les RefreshTokens d'un utilisateur donné
    public function deleteByUserId(int $userId)
    {
        return $this->createQueryBuilder('rt')
            ->delete()
            ->where('rt.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->execute();
    }
}
