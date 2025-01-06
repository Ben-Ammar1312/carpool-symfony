<?php

namespace App\Form;

class RefundRequest
{
    private string $paymentIntentId;

    public function __construct(string $paymentIntentId)
    {
        $this->paymentIntentId = $paymentIntentId;
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
