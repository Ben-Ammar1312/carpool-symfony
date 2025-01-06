<?php

namespace App\Enum;

use PhpParser\Node\Scalar\String_;

enum Type : string
{
    case conducteur = 'CONDUCTEUR';
    case passager = 'PASSAGER';
    case admin = 'admin';
}
