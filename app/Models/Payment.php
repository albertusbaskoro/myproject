<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        '_userid' => 'integer',
        'method' => 'string',
        'paymentgateway' => 'string',
        'statusmessage' => 'string',
        'status' => 'string',
        'amount' => 'float',
        'created' => 'timestamp',
        'modified' => 'timestamp',
    ];

    protected $visible = ['id', 'uuid' ,'_userid', 'method', 'paymentgateway', 'statusmessage', 'status', 'amount', 'created', 'modified'];

    public $timestamps = false;

    public function scopeHistory($query, $id)
    {
        return $query->where('_userid', $id);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
