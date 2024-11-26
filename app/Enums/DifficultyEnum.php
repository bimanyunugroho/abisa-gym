<?php

namespace App\Enums;

enum DifficultyEnum: string
{
    case PEMULA = 'pemula';
    case MENENGAH = 'menengah';
    case LANJUTAN = 'lanjutan';
    case AHLI = 'ahli';

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
