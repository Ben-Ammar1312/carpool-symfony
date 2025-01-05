<?php


namespace App\Entity;

use App\Entity\Conducteur;
use App\Entity\Passager;
use App\Enum\AvisType;
use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private int $id_avis;

    #[ORM\Column(type: 'float')]
    private float $note;

    #[ORM\Enumerated(EnumType::class)]
    #[ORM\Column(type: 'string', length: 50)]
    private AvisType $avisType;

    #[ORM\ManyToOne(targetEntity: Conducteur::class)]
    #[ORM\JoinColumn(name: 'id_conducteur', referencedColumnName: 'id')]
    private Conducteur $conducteur;

    #[ORM\ManyToOne(targetEntity: Passager::class)]
    #[ORM\JoinColumn(name: 'id_passager', referencedColumnName: 'id')]
    private Passager $passager;

    public function getIdAvis(): int
    {
        return $this->id_avis;
    }

    public function getNote(): float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function getAvisType(): AvisType
    {
        return $this->avisType;
    }

    public function setAvisType(AvisType $avisType): self
    {
        $this->avisType = $avisType;
        return $this;
    }

    public function getConducteur(): Conducteur
    {
        return $this->conducteur;
    }

    public function setConducteur(Conducteur $conducteur): self
    {
        $this->conducteur = $conducteur;
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
}


