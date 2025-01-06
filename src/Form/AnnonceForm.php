<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class AnnonceForm
{
    #[Assert\NotBlank]
    private string $lieuDepart;

    #[Assert\NotBlank]
    private string $lieuArrivee;

    #[Assert\NotNull]
    private ?float $departLat = null;

    #[Assert\NotNull]
    private ?float $departLng = null;

    #[Assert\NotNull]
    private ?float $arriveLat = null;

    #[Assert\NotNull]
    private ?float $arriveLng = null;

    #[Assert\NotNull]
    private ?\DateTimeInterface $dateDepart = null;

    #[Assert\NotBlank]
    private string $heureDepart;

    #[Assert\Positive]
    private int $nbrPlaces;

    #[Assert\Positive]
    private float $prix;

    /**
     * @var WaypointForm[]
     */
    private array $waypoints = [];

    // Getters and setters for all properties

    public function getLieuDepart(): string
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(string $lieuDepart): void
    {
        $this->lieuDepart = $lieuDepart;
    }

    public function getLieuArrivee(): string
    {
        return $this->lieuArrivee;
    }

    public function setLieuArrivee(string $lieuArrivee): void
    {
        $this->lieuArrivee = $lieuArrivee;
    }

    public function getDepartLat(): ?float
    {
        return $this->departLat;
    }

    public function setDepartLat(?float $departLat): void
    {
        $this->departLat = $departLat;
    }

    public function getDepartLng(): ?float
    {
        return $this->departLng;
    }

    public function setDepartLng(?float $departLng): void
    {
        $this->departLng = $departLng;
    }

    public function getArriveLat(): ?float
    {
        return $this->arriveLat;
    }

    public function setArriveLat(?float $arriveLat): void
    {
        $this->arriveLat = $arriveLat;
    }

    public function getArriveLng(): ?float
    {
        return $this->arriveLng;
    }

    public function setArriveLng(?float $arriveLng): void
    {
        $this->arriveLng = $arriveLng;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): void
    {
        $this->dateDepart = $dateDepart;
    }

    public function getHeureDepart(): string
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(string $heureDepart): void
    {
        $this->heureDepart = $heureDepart;
    }

    public function getNbrPlaces(): int
    {
        return $this->nbrPlaces;
    }

    public function setNbrPlaces(int $nbrPlaces): void
    {
        $this->nbrPlaces = $nbrPlaces;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    public function getWaypoints(): array
    {
        return $this->waypoints;
    }

    public function setWaypoints(array $waypoints): void
    {
        $this->waypoints = $waypoints;
    }
}
