<?php

namespace App\Repository;

use App\Entity\PickupPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PickPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PickupPoint::class);
    }

    // Trouver les points de ramassage associés à un annonce en fonction de son ID
    public function findByAnnonceId(int $annonceId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.annonce = :annonceId')
            ->setParameter('annonceId', $annonceId)
            ->getQuery()
            ->getResult();
    }
}
