<?php

namespace App\Entity;

use assets\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_message = null;

    #[ORM\Column(length: 100)]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    private Utilisateur $receiver;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'sentMessages')]
    private Utilisateur $sender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->date_message;
    }

    public function setDateMessage(\DateTimeInterface $date_message): static
    {
        $this->date_message = $date_message;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getReceiver(): ?Utilisateur
    {
        return $this->receiver;
    }

    public function setReceiver(Utilisateur $receiver): static
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function getSender(): ?Utilisateur
    {
        return $this->sender;
    }

    public function setSender(Utilisateur $sender): static
    {
        $this->sender = $sender;
        return $this;
    }
}
