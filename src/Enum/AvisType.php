<?php

namespace App\Enum;

enum AvisType: string
{
    case PASSENGER_TO_DRIVER = 'PASSENGER_TO_DRIVER';
    case DRIVER_TO_PASSENGER = 'DRIVER_TO_PASSENGER';
}

