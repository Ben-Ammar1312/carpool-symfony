<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDepart = null;

    #[ORM\Column]
    private ?int $nbrPlace = null;

    #[ORM\Column(length: 20)]
    private ?string $lieuDepart = null;

    #[ORM\Column(length: 50)]
    private ?string $lieuArrive = null;

    #[ORM\Column(length: 10)]
    private ?string $heureDepart = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 9)]
    private ?string $aller_retour = null;

    #[ORM\Column]
    private ?bool $regulier = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $prix = null;

    #[ORM\ManyToOne(targetEntity: Conducteur::class, inversedBy: "annonces")]
    private ?Conducteur $conducteur = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getNbrPlace(): ?int
    {
        return $this->nbrPlace;
    }

    public function setNbrPlace(int $nbrPlace): static
    {
        $this->nbrPlace = $nbrPlace;

        return $this;
    }

    public function getLieuDepart(): ?string
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(string $lieuDepart): static
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getLieuArrive(): ?string
    {
        return $this->lieuArrive;
    }

    public function setLieuArrive(string $lieuArrive): static
    {
        $this->lieuArrive = $lieuArrive;

        return $this;
    }

    public function getHeureDepart(): ?string
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(string $heureDepart): static
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAllerRetour(): ?string
    {
        return $this->aller_retour;
    }

    public function setAllerRetour(string $aller_retour): static
    {
        $this->aller_retour = $aller_retour;

        return $this;
    }

    public function isRegulier(): ?bool
    {
        return $this->regulier;
    }

    public function setRegulier(bool $regulier): static
    {
        $this->regulier = $regulier;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }


    public function getConducteur(): ?Conducteur
    {
        return $this->conducteur;
    }

    public function setConducteur(?Conducteur $conducteur): void
    {
        $this->conducteur = $conducteur;
    }
}
