<?php

namespace App\Enums;

enum PaymentTypeEnum: string
{
    case MEMBERSHIP = 'MEMBERSHIP';
    case WALK_IN = 'WALK_IN';
    case KELAS = 'KELAS';
    case TRAINING = 'TRAINING';
    case GUEST_VISIT = 'GUEST_VISIT';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::MEMBERSHIP => 'Membership',
            self::WALK_IN => 'Walk In',
            self::KELAS => 'Kelas',
            self::TRAINING => 'Training',
            self::GUEST_VISIT => 'Guest Visit',
        };
    }
}
