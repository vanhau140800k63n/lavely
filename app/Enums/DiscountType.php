<?php

namespace App\Enums;

enum DiscountType: string
{
    case FIXED = 'fixed';
    case PERCENT = 'percent';

    public function unit(): string
    {
        return match ($this) {
            self::FIXED => 'đ',
            self::PERCENT => '%',
        };
    }
}
