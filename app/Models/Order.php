<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'order';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'address_detail',
		'commune',
		'district',
		'province',
		'note',
		'shipping_fee',
		'total_price',
		'discount',
		'actual_price',
		'status',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'shipping_fee' => 'decimal:2',
		'total_price' => 'decimal:2',
		'discount' => 'decimal:2',
		'actual_price' => 'decimal:2',
		'status' => 'string',
	];

	public function orderProducts()
	{
		return $this->hasMany(OrderProduct::class, 'order_id', 'id');
	}
}
