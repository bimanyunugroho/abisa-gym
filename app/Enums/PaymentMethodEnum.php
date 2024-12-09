<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CASH = 'CASH';
    case CREDIT_CARD = 'CREDIT_CARD';
    case DEBIT_CARD = 'DEBIT_CARD';
    case TRANSFER = 'TRANSFER';
    case EWALLET = 'EWALLET';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::CASH => 'Tunai',
            self::CREDIT_CARD => 'Kartu Kredit',
            self::DEBIT_CARD => 'Kartu Debit',
            self::TRANSFER => 'Transfer',
            self::EWALLET => 'E-Wallet',
        };
    }
}
