<?php

namespace App\Entity;

use App\Repository\WaypointSuggestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WaypointSuggestionRepository::class)]
class WaypointSuggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "float")]
    private ?float $latitude = null;

    #[ORM\Column(type: "float")]
    private ?float $longitude = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: "boolean")]
    private bool $approvedByDriver = false;

    #[ORM\Column(type: "boolean")]
    private bool $isRejected = false;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: "waypoints")]
    #[ORM\JoinColumn(name: "idAnnonce", referencedColumnName: "idAnnonce", nullable: false)]
    private Annonce $annonce;

    #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: 'waypointSuggestions')]
    #[ORM\JoinColumn(name: "id_reservation", referencedColumnName: "id_reservation", nullable: true)]
    private ?Reservation $reservation = null;

    #[ORM\ManyToMany(targetEntity: Passager::class)]
    #[ORM\JoinTable(
        name: "waypoint_approval",
        joinColumns: [new ORM\JoinColumn(name: "waypoint_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "passenger_id", referencedColumnName: "id")]
    )]
    private Collection $approvedByPassengers;

    public function __construct()
    {
        $this->approvedByPassengers = new ArrayCollection();
    }

    // Getter and setter for id
    public function getId(): int
    {
        return $this->id;
    }

    // Getter and setter for latitude
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    // Getter and setter for longitude
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    // Getter and setter for address
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    // Getter and setter for approvedByDriver
    public function isApprovedByDriver(): bool
    {
        return $this->approvedByDriver;
    }

    public function setApprovedByDriver(bool $approvedByDriver): self
    {
        $this->approvedByDriver = $approvedByDriver;
        return $this;
    }

    // Getter and setter for isRejected
    public function isRejected(): bool
    {
        return $this->isRejected;
    }

    public function setRejected(bool $isRejected): self
    {
        $this->isRejected = $isRejected;
        return $this;
    }

    // Getter and setter for annonce
    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
    {
        $this->annonce = $annonce;
        return $this;
    }

    // Getter and setter for reservation
    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;
        return $this;
    }

    // Getter and setter for approvedByPassengers
    public function getApprovedByPassengers(): Collection
    {
        return $this->approvedByPassengers;
    }

    public function addApprovedByPassenger(Passager $passenger): self
    {
        if (!$this->approvedByPassengers->contains($passenger)) {
            $this->approvedByPassengers[] = $passenger;
        }
        return $this;
    }

    public function removeApprovedByPassenger(Passager $passenger): self
    {
        $this->approvedByPassengers->removeElement($passenger);
        return $this;
    }
}
