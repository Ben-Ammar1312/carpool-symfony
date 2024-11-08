<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_reclamation = null;

    #[ORM\Column(length: 100)]
    private ?string $sujet = null;

    #[ORM\Column(length: 20)]
    private ?string $titre = null;

    #[ORM\Column(length: 100)]
    private ?string $reponse_reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->date_reclamation;
    }

    public function setDateReclamation(\DateTimeInterface $date_reclamation): static
    {
        $this->date_reclamation = $date_reclamation;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getReponseReclamation(): ?string
    {
        return $this->reponse_reclamation;
    }

    public function setReponseReclamation(string $reponse_reclamation): static
    {
        $this->reponse_reclamation = $reponse_reclamation;

        return $this;
    }
    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "reclamations")]
    private Utilisateur $utilisateur;
}
