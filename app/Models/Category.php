<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'category';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'selly_category_id'
    ];

    // Define relationships, for example with Product if needed
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
