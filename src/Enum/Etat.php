<?php

namespace App\Enum;

enum Etat: string
{
    case VALIDE = 'VALIDE';
    case ANNULE = 'ANNULE';
    case EN_ATTENTE = 'EN_ATTENTE';
    case PAYMENT_PENDING = 'PAYMENT_PENDING';
}
