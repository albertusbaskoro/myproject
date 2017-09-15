<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $visible = [
		'id', 'uuid', 'amount', '_userid', 'deliverydate', '_addressid', 'address', 'addressextra', 'latitude', 'longitude', 'notes', '_couponid', 'couponcode', 'subtotal', 'discount', 'total', 'paymentstatus', 'status', 'useragent', 'iscompleted', 'created', 'modified'
	];

	protected $casts = [
		'id' => 'integer',
		'uuid' => 'string',
		'amount' => 'string',
		'_userid' => 'integer',
		'deliverydate' => 'integer',
		'_addressid' => 'integer',
		'address' => 'string',
		'addressextra' => 'string',
		'latitude' => 'float',
		'longitude' => 'float',
		'notes' => 'string',
		'_couponid' => 'integer',
		'couponcode' => 'string',
		'subtotal' => 'float',
		'discount' => 'float',
		'total' => 'integer',
		'paymentstatus' => 'string',
		'status' => 'string',
		'useragent' => 'string',
		'iscompleted' => 'integer',
		'created' => 'timestamp',
		'modified' => 'timestamp'
		];

    public $timestamps = false;
}

