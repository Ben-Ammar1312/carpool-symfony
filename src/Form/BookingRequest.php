<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class BookingRequest
{
    #[Assert\NotNull]
    #[Assert\Positive]
    private int $annonceId;

    #[Assert\NotNull]
    private ?float $pickupLat = null;

    #[Assert\NotNull]
    private ?float $pickupLng = null;

    #[Assert\NotNull]
    private bool $onRoute;

    #[Assert\NotBlank]
    private string $paymentMethod;

    public function getAnnonceId(): int
    {
        return $this->annonceId;
    }

    public function setAnnonceId(int $annonceId): void
    {
        $this->annonceId = $annonceId;
    }

    public function getPickupLat(): ?float
    {
        return $this->pickupLat;
    }

    public function setPickupLat(?float $pickupLat): void
    {
        $this->pickupLat = $pickupLat;
    }

    public function getPickupLng(): ?float
    {
        return $this->pickupLng;
    }

    public function setPickupLng(?float $pickupLng): void
    {
        $this->pickupLng = $pickupLng;
    }

    public function isOnRoute(): bool
    {
        return $this->onRoute;
    }

    public function setOnRoute(bool $onRoute): void
    {
        $this->onRoute = $onRoute;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }
}

