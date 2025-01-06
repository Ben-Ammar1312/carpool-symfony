<?php

namespace App\Form;

class NotificationDTO
{
    private ?int $notificationId;
    private string $message;
    private bool $read;
    private \DateTimeInterface $timestamp;

    // Constructors
    public function __construct(?int $notificationId = null, string $message = "", bool $read = false, \DateTimeInterface $timestamp = null)
    {
        $this->notificationId = $notificationId;
        $this->message = $message;
        $this->read = $read;
        $this->timestamp = $timestamp ?? new \DateTime();
    }

    public function getNotificationId(): ?int
    {
        return $this->notificationId;
    }

    public function setNotificationId(?int $notificationId): void
    {
        $this->notificationId = $notificationId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function isRead(): bool
    {
        return $this->read;
    }

    public function setRead(bool $read): void
    {
        $this->read = $read;
    }

    public function getTimestamp(): \DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
