<?php

namespace App\Enums;

enum DifficultyEnum: string
{
    case PEMULA = 'PEMULA';
    case MENENGAH = 'MENENGAH';
    case LANJUTAN = 'LANJUTAN';
    case AHLI = 'AHLI';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::PEMULA => 'Pemula',
            self::MENENGAH => 'Menengah',
            self::LANJUTAN => 'Lanjutan',
            self::AHLI => 'Ahli',
        };
    }
}
