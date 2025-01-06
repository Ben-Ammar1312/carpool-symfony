<?php

namespace App\Form;

class ConfirmPaymentBookingRequest
{
    private int $reservationId;
    private int $rideId;
    private string $paymentIntentId;

    public function __construct(int $reservationId, int $rideId, string $paymentIntentId)
    {
        $this->reservationId = $reservationId;
        $this->rideId = $rideId;
        $this->paymentIntentId = $paymentIntentId;
    }

    public function getReservationId(): int
    {
        return $this->reservationId;
    }

    public function setReservationId(int $reservationId): void
    {
        $this->reservationId = $reservationId;
    }

    public function getRideId(): int
    {
        return $this->rideId;
    }

    public function setRideId(int $rideId): void
    {
        $this->rideId = $rideId;
    }

    public function getPaymentIntentId(): string
    {
        return $this->paymentIntentId;
    }

    public function setPaymentIntentId(string $paymentIntentId): void
    {
        $this->paymentIntentId = $paymentIntentId;
    }
}
