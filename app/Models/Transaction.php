<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        '_accountid' => 'integer',
        '_userid' => 'integer',
        '_paymentid' => 'integer',
        '_orderid' => 'integer',
        'description' => 'string',
        'credit' => 'float',
        'debit' => 'float',
        'created' => 'timestamp',
        'modified' => 'timestamp',
    ];

    protected $visible = ['id', 'number' ,'_accountid', '_userid', '_paymentid', '_orderid', 'description', 'credit', 'debit', 'created', 'modified'];

    public $timestamps = false;
}
