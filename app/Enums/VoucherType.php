<?php

namespace App\Enums;

enum VoucherType: string
{
    case SHIPPING = 'shipping';
    case PRODUCT = 'product';
    case ORDER = 'order';

    public function image(): string
    {
        return match ($this) {
            self::SHIPPING => asset('image/voucher/free_shipping.png'),
            self::PRODUCT => asset('image/voucher/product.png'),
            self::ORDER => asset('image/voucher/order.png'),
        };
    }

    public function name(): string
    {
        return match ($this) {
            self::SHIPPING => 'Miễn phí vận chuyển',
            self::PRODUCT => 'Giảm giá sản phẩm',
            self::ORDER => 'Giảm giá đơn hàng',
        };
    }

    public function priority(): int
    {
        return match ($this) {
            self::PRODUCT => 1,
            self::ORDER => 2,
            self::SHIPPING => 3,
        };
    }
}
