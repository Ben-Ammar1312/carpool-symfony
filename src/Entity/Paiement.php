<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\Etat;
use App\Enum\Mode;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id_paiement;

    #[ORM\Column(type: "string", length: 255)]
    private string $date_paiement;

    #[ORM\Column(type: "float")]
    private float $montant;

    #[ORM\Column(type: "string", enumType: Etat::class)]
    private Etat $etat;

    #[ORM\Column(type: "string", enumType: Mode::class)]
    private Mode $mode;

    #[ORM\OneToOne(targetEntity: Reservation::class, inversedBy: "paiement", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "reservation_id", referencedColumnName: "id_reservation", nullable: false)]
    private Reservation $reservation;

    public function getIdPaiement(): int
    {
        return $this->id_paiement;
    }

    public function getDatePaiement(): string
    {
        return $this->date_paiement;
    }

    public function setDatePaiement(string $date_paiement): self
    {
        $this->date_paiement = $date_paiement;
        return $this;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
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

    public function getMode(): Mode
    {
        return $this->mode;
    }

    public function setMode(Mode $mode): self
    {
        $this->mode = $mode;
        return $this;
    }

    public function getReservation(): Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): self
    {
        $this->reservation = $reservation;
        return $this;
    }
}
