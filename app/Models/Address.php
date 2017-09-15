<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $visible = [
		'id', 'uuid', '_userid', 'name', 'label', 'address', 'addressextra', 'latitude', 'longitude', 'isdeleted'
	];

	protected $casts = [
		'id' => 'integer',
		'uuid' => 'string',
		'_userid' => 'integer',
		'name' => 'string',
		'label' => 'string',
		'address' => 'string',
		'addressextra' => 'string',
		'latitude' => 'float',
		'longitude' => 'float',
		'isdeleted' => 'integer'
		];

    public $timestamps = false;

    public function scopeOrder($query)
    {
    	return $query->orderBy('id', 'asc');
    	// return $query->where('_userid', '16006');
    }

    public function scopeSelected($query)
    {
    	return $query->where('isSelected', '1');
    	// return $query->where('_userid', '16006');
    }
}