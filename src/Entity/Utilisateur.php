<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\Turbo\Attribute\Broadcast;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["utilisateur" => Utilisateur::class, "conducteur" => Conducteur::class, "admin" => Admin::class, "passager" => Passager::class])]
#[Broadcast]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 10)]
    private ?string $genre = null;

    #[ORM\Column(length: 20)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePic = null;

    private array $roles = [];
    #[ORM\OneToMany(mappedBy: "sender", targetEntity: Message::class)]
    private Collection $sentMessages;
    #[ORM\OneToMany(mappedBy: "utilisateur", targetEntity: Reclamation::class)]
    private Collection $reclamations;

    #[ORM\OneToMany(mappedBy: "utilisateur", targetEntity: Avis::class)]
    private Collection $avis;

    public function __construct()
    {
        $this->sentMessages = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
        $this->avis = new ArrayCollection();
    }
      
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profilePic ?? '/images/default-profile.png';
    }

    public function setProfilePic(?string $profilePic): static
    {
        $this->profilePic = $profilePic;
        return $this;
    }

 
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }
    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string{
        return $this->email; // Ou une autre propriété unique pour identifier l'utilisateur

}



    public function getSalt(): ?string
    {
        return null;
    }



    public function eraseCredentials(): void
    {
        // Efface les données sensibles, comme le mot de passe brut
    }
}
