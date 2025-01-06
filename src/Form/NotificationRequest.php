<?php

namespace App\Form;

class NotificationRequest
{
    private int $userId;
    private string $message;

    public function __construct(int $userId, string $message)
    {
        $this->userId = $userId;
        $this->message = $message;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
