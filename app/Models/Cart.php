<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	use HasFactory;

	protected $table = 'cart';

	protected $fillable = [
		'user_id',
		'product_id',
		'prod_item_id',
		'quantity',
		'price',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function prodItem()
	{
		return $this->belongsTo(ProdItem::class);
	}

	public function cartProductInfo()
	{
		return [
			"product_id" =>	$this->product_id,
			"quantity"	=> $this->quantity
		];
	}
}
