<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow the Laravel naming convention
    protected $table = 'product_status';

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'product_code',
        'status',
    ];

    // Optionally, disable timestamps if you don't want to track created_at and updated_at
    public $timestamps = true;
}
