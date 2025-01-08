<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherProduct extends Model
{
    protected $table = 'voucher_product';
    protected $fillable = [
        'voucher_id',
        'product_id',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
