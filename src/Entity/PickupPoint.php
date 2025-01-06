<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PickupPointRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PickupPointRepository::class)]
class PickupPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "float")]
    private ?float $latitude;

    #[ORM\Column(type: "float")]
    private ?float $longitude;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $address;


    // Getters and Setters

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: "pickupPoints")]
    #[ORM\JoinColumn(name: "idAnnonce", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Annonce $annonce;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
    {
        $this->annonce = $annonce;
        return $this;
    }
}



