<?php

namespace App\Form;

class ChatMessage
{
    private int $senderId;
    private int $receiverId;
    private string $content;
    private string $senderName;
    private \DateTimeInterface $timestamp;
    private int $rideId;

    public function __construct(
        int $senderId,
        int $receiverId,
        string $content,
        string $senderName,
        \DateTimeInterface $timestamp,
        int $rideId
    ) {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->content = $content;
        $this->senderName = $senderName;
        $this->timestamp = $timestamp;
        $this->rideId = $rideId;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function setReceiverId(int $receiverId): void
    {
        $this->receiverId = $receiverId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getSenderName(): string
    {
        return $this->senderName;
    }

    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }

    public function getTimestamp(): \DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getRideId(): int
    {
        return $this->rideId;
    }

    public function setRideId(int $rideId): void
    {
        $this->rideId = $rideId;
    }
}
