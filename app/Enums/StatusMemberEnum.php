<?php

namespace App\Enums;

enum StatusMemberEnum: string
{
    case ACTIVE = 'ACTIVE';
    case EXPIRED = 'EXPIRED';
    case CANCELLED = 'CANCELLED';
    case FROZEN = 'FROZEN';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Aktif',
            self::EXPIRED => 'Kadaluarsa',
            self::CANCELLED => 'Dibatalkan',
            self::FROZEN => 'Dibekukan',
        };
    }
}
