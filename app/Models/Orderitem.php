<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    protected $table = 'orderitem';

    protected $visible = [
		'id', '_mealid', 'uuid', '_cookid', 'notes', 'price', 'originalprice', 'amount', 'weight', 'deliverydate', '_orderid'
	];

	protected $casts = [
		'id' => 'integer',
		'_mealid' => 'integer',
		'uuid' => 'string',
		'_cookid' => 'integer',
		'notes' => 'string',
		'price' => 'float',
		'originalprice' => 'float',
		'amount' => 'float',
		'weight' => 'float',
		'deliverydate' => 'timestamp',
		'_orderid' => 'integer'
		];

    public $timestamps = false;
}
