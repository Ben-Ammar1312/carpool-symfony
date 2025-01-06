<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\Etat;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id_reservation;

    #[ORM\Column(type: "string", length: 255)]
    private string $date_reservation;

    #[ORM\Column(type: "integer")]
    private int $nbrPlaces;

    #[ORM\Column(type: "string", enumType: Etat::class)]
    private Etat $etat;

    #[ORM\ManyToOne(targetEntity: Passager::class, inversedBy: "reservations")]
    #[ORM\JoinColumn(nullable: false)]
    private Passager $passager;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: "reservations")]
    #[ORM\JoinColumn(name: "idAnnonce", referencedColumnName: "id_annonce", nullable: false)]
    private Annonce $annonce;

    #[ORM\OneToOne(mappedBy: "reservation", targetEntity: Paiement::class, cascade: ["persist", "remove"])]
    private ?Paiement $paiement = null;

    #[ORM\OneToMany(targetEntity: WaypointSuggestion::class, mappedBy: "reservation", cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $waypointSuggestions;

    #[ORM\OneToMany(targetEntity: Waypoint::class, mappedBy: "reservation", cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $waypoints;

    public function __construct()
    {
        $this->waypointSuggestions = new ArrayCollection();
        $this->waypoints = new ArrayCollection();
    }

    public function getIdReservation(): int
    {
        return $this->id_reservation;
    }

    public function getDateReservation(): string
    {
        return $this->date_reservation;
    }

    public function setDateReservation(string $date_reservation): self
    {
        $this->date_reservation = $date_reservation;
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

    public function getEtat(): Etat
    {
        return $this->etat;
    }

    public function setEtat(Etat $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    public function getPassager(): Passager
    {
        return $this->passager;
    }

    public function setPassager(Passager $passager): self
    {
        $this->passager = $passager;
        return $this;
    }

    public function getAnnonce(): Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
    {
        $this->annonce = $annonce;
        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): self
    {
        if ($this->paiement !== null) {
            $this->paiement->setReservation(null);
        }

        $this->paiement = $paiement;

        if ($paiement !== null) {
            $paiement->setReservation($this);
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
            $waypointSuggestion->setReservation($this);
        }

        return $this;
    }

    public function removeWaypointSuggestion(WaypointSuggestion $waypointSuggestion): self
    {
        if ($this->waypointSuggestions->removeElement($waypointSuggestion)) {
            if ($waypointSuggestion->getReservation() === $this) {
                $waypointSuggestion->setReservation(null);
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
            $waypoint->setReservation($this);
        }

        return $this;
    }

    public function removeWaypoint(Waypoint $waypoint): self
    {
        if ($this->waypoints->removeElement($waypoint)) {
            if ($waypoint->getReservation() === $this) {
                $waypoint->setReservation(null);
            }
        }

        return $this;
    }
}
