<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    /**
     * Calculer la moyenne des notes pour un conducteur donné.
     *
     * @param int $driverId
     * @return float
     */
    public function findAverageRatingForDriver(int $driverId): float
    {
        $query = $this->createQueryBuilder('a')
            ->select('COALESCE(AVG(a.note), 0)')
            ->where('a.conducteur = :driverId')
            ->andWhere('a.avisType = :avisType')
            ->setParameter('driverId', $driverId)
            ->setParameter('avisType', 'PASSENGER_TO_DRIVER')
            ->getQuery();

        return (float) $query->getSingleScalarResult();
    }

    /**
     * Calculer la moyenne des notes pour un passager donné.
     *
     * @param int $passengerId
     * @return float
     */
    public function findAverageRatingForPassenger(int $passengerId): float
    {
        $query = $this->createQueryBuilder('a')
            ->select('COALESCE(AVG(a.note), 0)')
            ->where('a.passager = :passengerId')
            ->andWhere('a.avisType = :avisType')
            ->setParameter('passengerId', $passengerId)
            ->setParameter('avisType', 'DRIVER_TO_PASSENGER')
            ->getQuery();

        return (float) $query->getSingleScalarResult();
    }
}
