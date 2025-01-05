<?php

namespace App\Enum;

enum Status: string
{
    case OPEN = 'Open';
    case FULL = 'Full';
    case CANCELLED = 'Cancelled';
}
