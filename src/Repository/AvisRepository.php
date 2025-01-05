<?php

// src/Repository/AvisRepository.php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Func;

class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    public function findAverageRatingForDriver(int $driverId): float
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('COALESCE(AVG(a.note), 0)')
            ->where('a.conducteur = :driverId')
            ->andWhere('a.avisType = :avisType')
            ->setParameter('driverId', $driverId)
            ->setParameter('avisType', 'PASSENGER_TO_DRIVER');

        return (float) $qb->getQuery()->getSingleScalarResult();
    }

    public function findAverageRatingForPassenger(int $passengerId): float
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('COALESCE(AVG(a.note), 0)')
            ->where('a.passager = :passengerId')
            ->andWhere('a.avisType = :avisType')
            ->setParameter('passengerId', $passengerId)
            ->setParameter('avisType', 'DRIVER_TO_PASSENGER');

        return (float) $qb->getQuery()->getSingleScalarResult();
    }
}
