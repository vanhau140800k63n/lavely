<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'shop';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'selly_shop_id',
        'image',
        'description',
        'product_count',
        'sold_count',
        'location'
    ];

    // Define relationships, for example with Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
