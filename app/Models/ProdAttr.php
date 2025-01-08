<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdAttr extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'prod_attr';

    // The attributes that are mass assignable
    protected $fillable = ['name', 'product_id', 'selly_attr_prod_id'];

    public function values()
    {
        return $this->hasMany(ProdAttrVal::class, 'prod_attr_id');
    }
}
