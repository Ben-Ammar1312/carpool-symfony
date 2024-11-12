<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_reservation = null;

    #[ORM\Column]
    private ?int $nbrplace = null;

    #[ORM\Column(nullable: true)]
    private ?bool $validite = null;

    #[ORM\Column(length: 20)]
    private ?string $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDateReservation(\DateTimeInterface $date_reservation): static
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

    public function getNbrplace(): ?int
    {
        return $this->nbrplace;
    }

    public function setNbrplace(int $nbrplace): static
    {
        $this->nbrplace = $nbrplace;

        return $this;
    }

    public function isValidite(): ?bool
    {
        return $this->validite;
    }

    public function setValidite(?bool $validite): static
    {
        $this->validite = $validite;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
    #[ORM\ManyToOne(targetEntity: Annonce::class)]
    private ?Annonce $annonce;

}
