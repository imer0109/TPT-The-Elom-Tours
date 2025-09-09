<?php

namespace App\Enums;

use App\Traits\EnumsValuesTrait;

enum RoleEnum: string
{
    use EnumsValuesTrait;
    case SUPER_ADMIN = 'Super Administrateur';
    case ADMIN = 'Administrateur';
    case USER = 'Utilisateur';
    
}
