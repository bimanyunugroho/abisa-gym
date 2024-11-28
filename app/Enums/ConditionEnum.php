<?php

namespace App\Enums;

enum ConditionEnum: string
{
    case SANGAT_BAIK = 'SANGAT BAIK';
    case BAIK = 'BAIK';
    case CUKUP = 'CUKUP';
    case RUSAK_RINGAN = 'RUSAK RINGAN';
    case RUSAK_BERAT = 'RUSAK BERAT';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::SANGAT_BAIK => 'Sangat Baik',
            self::BAIK => 'Baik',
            self::CUKUP => 'Cukup',
            self::RUSAK_RINGAN => 'Rusak Ringan',
            self::RUSAK_BERAT => 'Rusak Berat',
        };
    }
}
