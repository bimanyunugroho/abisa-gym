<?php

namespace App\Enums;

enum DurationTypeEnum: string
{
    case DAYS = 'DAYS';
    case MONTHS = 'MONTHS';
    case YEARS = 'YEARS';
    case UNLIMITED = 'UNLIMITED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::DAYS => 'Harian',
            self::MONTHS => 'Bulanan',
            self::YEARS => 'Tahunan',
            self::UNLIMITED => 'Tak Terbatas',
        };
    }
}
