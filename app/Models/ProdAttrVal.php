<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdAttrVal extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'prod_attr_val';

    // The attributes that are mass assignable
    protected $fillable = ['prod_attr_id', 'value', 'image_id', 'selly_prod_attr_val_id'];

    // Relationship with ProdAttr (Each ProdAttrVal belongs to a ProdAttr)
    public function prodAttr()
    {
        return $this->belongsTo(ProdAttr::class, 'prod_attr_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
