<?php

namespace App\Repository;

use App\Entity\VerificationToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VerificationTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VerificationToken::class);
    }

    public function findByToken(string $token): ?VerificationToken
    {
        return $this->createQueryBuilder('v')
            ->where('v.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
