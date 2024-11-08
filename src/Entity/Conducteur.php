<?php

namespace App\Entity;

use App\Repository\ConducteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConducteurRepository::class)]
class Conducteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $cin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }
    #[ORM\OneToMany(mappedBy: "conducteur", targetEntity: Annonce::class)]
    private Collection $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }
}
