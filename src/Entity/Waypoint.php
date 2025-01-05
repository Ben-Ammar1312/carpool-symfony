<?php

namespace App\Entity;

use App\Repository\WaypointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WaypointRepository::class)]
class Waypoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
<<<<<<< HEAD
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'float')]
    private float $latitude;

    #[ORM\Column(type: 'float')]
    private float $longitude;

    #[ORM\Column(type: 'string', length: 255)]
    private string $address;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: 'waypoints')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annonce $annonce = null;

    #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: 'waypoints')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Reservation $reservation = null;

    // Getters and Setters
=======
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "float")]
    private ?float $latitude = null;

    #[ORM\Column(type: "float")]
    private ?float $longitude = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: "waypoints")]
    #[ORM\JoinColumn(name: "idAnnonce", referencedColumnName: "idAnnonce", nullable: false)]
    private Annonce $annonce;

    #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: 'waypoints')]
    #[ORM\JoinColumn(name: "id_reservation", referencedColumnName: "id_reservation", nullable: false)]  // Correction ici
    private ?Reservation $reservation = null;

>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
    public function getId(): int
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function getLatitude(): float
=======
    public function getLatitude(): ?float
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
    {
        return $this->latitude;
    }

<<<<<<< HEAD
    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): float
=======
    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?float
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
    {
        return $this->longitude;
    }

<<<<<<< HEAD
    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAddress(): string
=======
    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getAddress(): ?string
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
    {
        return $this->address;
    }

<<<<<<< HEAD
    public function setAddress(string $address): self
    {
        $this->address = $address;

=======
    public function setAddress(?string $address): self
    {
        $this->address = $address;
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;
<<<<<<< HEAD

=======
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;
<<<<<<< HEAD

=======
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
        return $this;
    }
}
