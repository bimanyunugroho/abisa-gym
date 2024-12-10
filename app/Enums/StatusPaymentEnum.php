<?php

namespace App\Enums;

enum StatusPaymentEnum: string
{
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case FAILED = 'FAILED';
    case REFUNDED = 'REFUNDED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Menunggu',
            self::COMPLETED => 'Selesai',
            self::FAILED => 'Gagal',
            self::REFUNDED => 'Dikembalikan',
        };
    }
}
