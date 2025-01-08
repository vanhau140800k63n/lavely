<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'brand';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'selly_brand_id',
        'image',
        'description'
    ];

    // Define relationships, for example with Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
