<?php

namespace App\Entity;

use App\Enum\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonceRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    #[Groups(['annonce:read', 'annonce:write'])]
    private int $id;

    #[ORM\Column(type: "date")]
    #[Groups(['annonce:read', 'annonce:write'])]
    private \DateTimeInterface $dateDepart;

    #[ORM\Column(type: "float")]
    #[Groups(['annonce:read', 'annonce:write'])]
    private float $prix;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private string $heureDepart;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private string $lieuArrivee;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private string $lieuDepart;

    #[ORM\Column(type: "integer")]
    #[Groups(['annonce:read', 'annonce:write'])]
    private int $nbrPlaces;

    #[ORM\Column(type: "boolean")]
    #[Groups(['annonce:read', 'annonce:write'])]
    private bool $isCanceled = false;

    #[ORM\Column(type: "float", nullable: true)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private ?float $departLat = null;

    #[ORM\Column(type: "float", nullable: true)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private ?float $departLng = null;

    #[ORM\Column(type: "float", nullable: true)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private ?float $arriveLat = null;

    #[ORM\Column(type: "float", nullable: true)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private ?float $arriveLng = null;

    #[ORM\Column(type: "string", enumType: Status::class)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private Status $status;

    #[ORM\ManyToOne(targetEntity: Conducteur::class, inversedBy: "annonces")]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id", nullable: false)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private Conducteur $conducteur;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: "annonce", cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $reservations;

    #[ORM\OneToMany(targetEntity: WaypointSuggestion::class, mappedBy: "annonce", cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $waypointSuggestions;

    #[ORM\OneToMany(targetEntity: Waypoint::class, mappedBy: "annonce", cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $waypoints;

    #[ORM\OneToMany(targetEntity: PickupPoint::class, mappedBy: "annonce", cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $pickupPoints;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(['annonce:read', 'annonce:write'])]
    private ?string $title = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->waypointSuggestions = new ArrayCollection();
        $this->waypoints = new ArrayCollection();
        $this->pickupPoints = new ArrayCollection();
    }

    // Getters and Setters

    public function getIdAnnonce(): int
    {
        return $this->idAnnonce;
    }

    public function getDateDepart(): \DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;
        return $this;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getHeureDepart(): string
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(string $heureDepart): self
    {
        $this->heureDepart = $heureDepart;
        return $this;
    }

    public function getLieuArrivee(): string
    {
        return $this->lieuArrivee;
    }

    public function setLieuArrivee(string $lieuArrivee): self
    {
        $this->lieuArrivee = $lieuArrivee;
        return $this;
    }

    public function getLieuDepart(): string
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(string $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;
        return $this;
    }

    public function getNbrPlaces(): int
    {
        return $this->nbrPlaces;
    }

    public function setNbrPlaces(int $nbrPlaces): self
    {
        $this->nbrPlaces = $nbrPlaces;
        return $this;
    }

    public function isCanceled(): bool
    {
        return $this->isCanceled;
    }

    public function setCanceled(bool $isCanceled): self
    {
        $this->isCanceled = $isCanceled;
        return $this;
    }

    public function getDepartLat(): ?float
    {
        return $this->departLat;
    }

    public function setDepartLat(?float $departLat): self
    {
        $this->departLat = $departLat;
        return $this;
    }

    public function getDepartLng(): ?float
    {
        return $this->departLng;
    }

    public function setDepartLng(?float $departLng): self
    {
        $this->departLng = $departLng;
        return $this;
    }

    public function getArriveLat(): ?float
    {
        return $this->arriveLat;
    }

    public function setArriveLat(?float $arriveLat): self
    {
        $this->arriveLat = $arriveLat;
        return $this;
    }

    public function getArriveLng(): ?float
    {
        return $this->arriveLng;
    }

    public function setArriveLng(?float $arriveLng): self
    {
        $this->arriveLng = $arriveLng;
        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getConducteur(): Conducteur
    {
        return $this->conducteur;
    }

    public function setConducteur(Conducteur $conducteur): self
    {
        $this->conducteur = $conducteur;
        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setAnnonce($this);
        }
        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getAnnonce() === $this) {
                $reservation->setAnnonce(null);
            }
        }
        return $this;
    }

    public function getWaypointSuggestions(): Collection
    {
        return $this->waypointSuggestions;
    }

    public function addWaypointSuggestion(WaypointSuggestion $waypointSuggestion): self
    {
        if (!$this->waypointSuggestions->contains($waypointSuggestion)) {
            $this->waypointSuggestions[] = $waypointSuggestion;
            $waypointSuggestion->setAnnonce($this);
        }
        return $this;
    }

    public function removeWaypointSuggestion(WaypointSuggestion $waypointSuggestion): self
    {
        if ($this->waypointSuggestions->removeElement($waypointSuggestion)) {
            if ($waypointSuggestion->getAnnonce() === $this) {
                $waypointSuggestion->setAnnonce(null);
            }
        }
        return $this;
    }

    public function getWaypoints(): Collection
    {
        return $this->waypoints;
    }

    public function addWaypoint(Waypoint $waypoint): self
    {
        if (!$this->waypoints->contains($waypoint)) {
            $this->waypoints[] = $waypoint;
            $waypoint->setAnnonce($this);
        }
        return $this;
    }

    public function removeWaypoint(Waypoint $waypoint): self
    {
        if ($this->waypoints->removeElement($waypoint)) {
            if ($waypoint->getAnnonce() === $this) {
                $waypoint->setAnnonce(null);
            }
        }
        return $this;
    }

    public function getPickupPoints(): Collection
    {
        return $this->pickupPoints;
    }

    public function addPickupPoint(PickupPoint $pickupPoint): self
    {
        if (!$this->pickupPoints->contains($pickupPoint)) {
            $this->pickupPoints[] = $pickupPoint;
            $pickupPoint->setAnnonce($this);
        }
        return $this;
    }

    public function removePickupPoint(PickupPoint $pickupPoint): self
    {
        if ($this->pickupPoints->removeElement($pickupPoint)) {
            if ($pickupPoint->getAnnonce() === $this) {
                $pickupPoint->setAnnonce(null);
            }
        }
        return $this;
    }

    // Getter and Setter for title
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }
}