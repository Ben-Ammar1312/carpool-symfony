<?php

namespace App\Repository;

use App\Entity\Conducteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ConducteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conducteur::class);
    }

    public function findByEmail(string $email): ?Conducteur
    {
        return $this->createQueryBuilder('c')
            ->where('c.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
