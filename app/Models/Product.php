<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'product';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'original_price',
        'max_price',
        'selling_price',
        'sold',
        'rate',
        'brand_id',
        'category_id',
        'description',
        'shop_id',
        'selly_product_id'
    ];

    // Define relationships
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function image_url()
    {
        $image = Image::where('product_id', $this->id)->first();
        return is_null($image) ? '' : $image->url;
    }
}
