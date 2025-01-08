<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdItem extends Model
{
    use HasFactory;

    protected $table = 'prod_item';

    protected $fillable = [
        'attr',
        'image',
        'product_id',
        'is_out_of_stock'
    ];

    public function getAttrIdsAttribute()
    {
        return explode('-', $this->attr);
    }

    public function prodAttrVals()
    {
        return ProdAttrVal::whereIn('id', $this->attr_ids)->get();
    }
}
