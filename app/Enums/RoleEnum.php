<?php

namespace App\Enums;

enum RoleEnum: string
{
    case OWNER = 'OWNER';
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case ADMIN = 'ADMIN';
    case TRAINER = 'TRAINER';
    case MEMBER = 'MEMBER';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::OWNER => 'Owner',
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::TRAINER => 'Trainer',
            self::MEMBER => 'Member',
        };
    }
}
