<?php

namespace App\Models;

use App\Enums\DiscountType;
use App\Enums\VoucherStatus;
use App\Enums\VoucherType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = "voucher";
    protected $fillable = [
        'code',
        'description',
        'type',
        'discount_type',
        'discount_amount',
        'minimum_spend',
        'maximum_discount',
        'start_date',
        'end_date',
        'quantity',
        'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'voucher_product', 'voucher_id', 'product_id');
    }

    public function voucherType()
    {
        return VoucherType::tryFrom($this->type);
    }

    public function discountType()
    {
        return DiscountType::tryFrom($this->discount_type);
    }

    public function voucherStatus()
    {
        return VoucherStatus::tryFrom($this->status);
    }

    public function isValid()
    {
        return $this->voucherStatus() === VoucherStatus::ACTIVE &&
            $this->quantity > 0 &&
            $this->start_date <= now() &&
            $this->end_date >= now();
    }

    public function isApplicableToOrder($totalAmount)
    {
        return $totalAmount >= $this->minimum_spend;
    }

    public function isApplicableToProduct($productId)
    {
        if ($this->type !== VoucherType::PRODUCT) return false;
        return $this->products()->where('product_id', $productId)->exists();
    }
}
