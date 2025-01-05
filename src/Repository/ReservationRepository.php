<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $reservation, bool $flush = false): void
    {
        $this->getEntityManager()->persist($reservation);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $reservation, bool $flush = false): void
    {
        $this->getEntityManager()->remove($reservation);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByPassagerIdAndEtat(int $userId, string $etat): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.passager = :userId')
            ->andWhere('r.etat = :etat')
            ->setParameter('userId', $userId)
            ->setParameter('etat', $etat)
            ->getQuery()
            ->getResult();
    }

    public function findByAnnonceIdAndPassagerId(int $annonceId, int $passagerId): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->where('r.annonce = :annonceId')
            ->andWhere('r.passager = :passagerId')
            ->setParameter('annonceId', $annonceId)
            ->setParameter('passagerId', $passagerId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
