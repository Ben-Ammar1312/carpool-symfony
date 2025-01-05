<?php

namespace App\Service;

use App\Entity\Annonce;
use App\Entity\PickupPoint;
use App\Entity\Waypoint;
use App\Entity\WaypointSuggestion;
use App\Repository\AnnonceRepository;
use App\Repository\PickPointRepository;
use App\Repository\WaypointRepository;
use App\Repository\WaypointSuggestionRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\Required;
use Doctrine\Common\Collections\Collection;

class AnnonceService
{
    private AnnonceRepository $annonceRepository;
    private PickPointRepository $pickupPointRepository;
    private WaypointSuggestionRepository $waypointSuggestionRepository;
    private WaypointRepository $waypointRepository;

    public function __construct(
        AnnonceRepository $annonceRepository,
        PickPointRepository $pickupPointRepository,
        WaypointSuggestionRepository $waypointSuggestionRepository,
        WaypointRepository $waypointRepository
    ) {
        $this->annonceRepository = $annonceRepository;
        $this->pickupPointRepository = $pickupPointRepository;
        $this->waypointSuggestionRepository = $waypointSuggestionRepository;
        $this->waypointRepository = $waypointRepository;
    }

    public function findById(int $id): ?Annonce
    {
        return $this->annonceRepository->find($id);
    }

    public function findAllByIds(array $ids): array
    {
        return $this->annonceRepository->findBy(['idAnnonce' => $ids]);
    }

    public function getAllAnnonces(): array
    {
        return $this->annonceRepository->findAll();
    }

    public function updateAnnonce(Annonce $annonce): void
    {
        $existingAnnonce = $this->annonceRepository->find($annonce->getIdAnnonce());

        if (!$existingAnnonce) {
            throw new \RuntimeException('Annonce non trouvée');
        }

        $existingAnnonce->setLieuDepart($annonce->getLieuDepart());
        $existingAnnonce->setLieuArrivee($annonce->getLieuArrivee());
        $existingAnnonce->setDateDepart($annonce->getDateDepart());
        $existingAnnonce->setHeureDepart($annonce->getHeureDepart());
        $existingAnnonce->setNbrPlaces($annonce->getNbrPlaces());
        $existingAnnonce->setPrix($annonce->getPrix());

        $this->annonceRepository->save($existingAnnonce);
    }

    public function deleteAnnonceById(int $id): void
    {
        $this->annonceRepository->delete($id);
    }

    public function cancelAnnonce(int $id): void
    {
        $annonce = $this->annonceRepository->find($id);
        if (!$annonce) {
            throw new \RuntimeException('Annonce introuvable');
        }

        $annonce->setCanceled(true);
        $this->annonceRepository->save($annonce);
    }

    public function saveAnnonce(Annonce $annonce): Annonce
    {
        // Save associated waypoints
        foreach ($annonce->getWaypoints() as $waypoint) {
            $waypoint->setAnnonce($annonce);
        }

        return $this->annonceRepository->save($annonce);
    }

    public function getPickupPointsByAnnonce(int $annonceId): array
    {
        return $this->pickupPointRepository->findBy(['annonce' => $annonceId]);
    }

    public function proposeWaypoint(WaypointSuggestion $waypointSuggestion): WaypointSuggestion
    {
        return $this->waypointSuggestionRepository->save($waypointSuggestion);
    }

    public function getWaypointSuggestionsByAnnonce(int $annonceId): array
    {
        return $this->waypointSuggestionRepository->findBy(['annonce' => $annonceId]);
    }

    public function searchRides(
        ?string $lieuDepart,
        ?string $lieuArrivee,
        ?string $dateDepart,
        ?int $nbrPlaces,
        ?float $maxPrice
    ): array {
        return $this->annonceRepository->searchRides(
            $lieuDepart, $lieuArrivee, $dateDepart, $nbrPlaces, $maxPrice
        );
    }
}
