<?php

namespace App\Entity;

use App\Repository\WaypointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WaypointRepository::class)]
class Waypoint
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

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: "waypoints")]
    #[ORM\JoinColumn(name: "idAnnonce", referencedColumnName: "id_annonce", nullable: false)]
    private Annonce $annonce;

    #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: 'waypoints')]
    #[ORM\JoinColumn(name: "id_reservation", referencedColumnName: "id_reservation", nullable: true)]
    private ?Reservation $reservation = null;

    // Getter and Setter for id
    public function getId(): int
    {
        return $this->id;
    }

    // Getter and Setter for latitude
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    // Getter and Setter for longitude
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    // Getter and Setter for address
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    // Getter and Setter for annonce
    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;
        return $this;
    }

    // Getter and Setter for reservation
    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;
        return $this;
    }
}