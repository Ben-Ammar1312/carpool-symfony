<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'chats')]
    #[ORM\JoinColumn(name: 'annonce_id', nullable: false)]
    private ?Annonce $annonce = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'chats', fetch: 'EAGER')]
    #[ORM\JoinTable(
        name: 'chat_participants',
        joinColumns: [new ORM\JoinColumn(name: 'chat_id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'user_id')]
    )]
    private Collection $participants;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'chat', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $messages;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
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

    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Utilisateur $user): self
    {
        if (!$this->participants->contains($user)) {
            $this->participants->add($user);
            $user->addChat($this);
        }

        return $this;
    }

    public function removeParticipant(Utilisateur $user): self
    {
        if ($this->participants->removeElement($user)) {
            $user->removeChat($this);
        }

        return $this;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setChat($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            $message->setChat(null);
        }

        return $this;
    }
}
