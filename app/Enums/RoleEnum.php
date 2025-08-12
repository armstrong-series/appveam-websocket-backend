<?php

namespace App\Enums;

enum RoleEnum: string
{
    case Customer   = 'customer';
    case Admin      = 'admin';
    case SuperAdmin = 'super_admin';
    case Support    = 'support';
    case User = 'user';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}