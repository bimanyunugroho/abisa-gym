<?php

namespace App\Enums;

enum GenderEnum: string
{
    case MAN = 'MAN';
    case WOMAN = 'WOMAN';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::MAN => 'Laki-laki',
            self::WOMAN => 'Perempuan',
        };
    }
}
