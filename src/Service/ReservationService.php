<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\Etat;
use App\Repository\ReservationRepository;

class ReservationService
{
    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function save(Reservation $reservation): void
    {
        $this->reservationRepository->save($reservation, true);
    }

    public function getBookedAnnonceIdsByUser(int $userId): array
    {
        $reservations = $this->reservationRepository->findByPassagerIdAndEtat($userId, Etat::VALIDE);

        return array_map(fn($reservation) => $reservation->getAnnonce()->getIdAnnonce(), $reservations);
    }

    public function getPendingAnnonceIdsByUser(int $userId): array
    {
        $reservations = $this->reservationRepository->findByPassagerIdAndEtat($userId, Etat::EN_ATTENTE);

        return array_map(fn($reservation) => $reservation->getAnnonce()->getIdAnnonce(), $reservations);
    }

    public function findByAnnonceIdAndPassagerId(int $annonceId, int $passagerId): ?Reservation
    {
        return $this->reservationRepository->findByAnnonceIdAndPassagerId($annonceId, $passagerId);
    }

    public function delete(Reservation $reservation): void
    {
        $this->reservationRepository->remove($reservation, true);
    }

    public function findById(int $id): ?Reservation
    {
        return $this->reservationRepository->find($id);
    }
}
