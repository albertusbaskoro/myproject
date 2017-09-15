<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sideitem extends Model
{
    protected $table = 'sideitem';

    protected $visible = [
		'id', '_sideid', 'uuid', 'notes', 'price', 'originalprice', 'amount', 'weight', 'deliverydate', '_orderid', '_orderitemid', 'created_at', 'deleted_at'
	];

    protected $casts = [
        'id' => 'integer',
        '_sideid' => 'integer',
        'uuid' => 'string',
        'notes' => 'string',
        'price' => 'float',
        'originalprice' => 'float',
        'amount' => 'float',
        'weight' => 'float',
        'deliverydate' => 'string',
        '_orderid' => 'integer',
        '_orderitemid' => 'integer',
        'created_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];
}
