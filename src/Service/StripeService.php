<?php

namespace App\Service;

use Stripe\Stripe;

class StripeService
{
    private $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
        $this->initialize();
    }

    private function initialize()
    {
        Stripe::setApiKey($this->secretKey);
    }
}

