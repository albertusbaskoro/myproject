<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Side extends Model
{
    protected $table = 'side';

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'price' => 'float',
        'originalprice' => 'float',
        'order' => 'integer',
        'image' => 'string',
        'isavailable' => 'boolean',
    ];

    public function scopeAvailable($query)
    {
    	return $query->where('isavailable', '1');
    }

}
