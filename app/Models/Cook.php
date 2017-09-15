<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;

class Cook extends Model
{
    protected $table = 'cook';

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'slug' => 'string',
        'fullname' => 'string',
        'nickname' => 'string',
        'callsign' => 'string',
        'summary' => 'string',
        'description' => 'string',
        'quota' => 'integer',
        'operationaldays' => 'string',
        'npwp' => 'string',
        'address' => 'string',
        'addressextra' => 'string',
        'phone' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'status' => 'string',
        'created' => 'timestamp',
        'modified' => 'timestamp',
        'isdeleted' => 'boolean',
        'since' => 'date',
        '_userid' => 'integer',
    ];

    // use SoftDeletes;

    public $incrementing = false;

    protected $visible = ['id', 'uuid', 'nickname' ,'fullname', 'description', 'since', 'addressextra'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeIdScope($query, $id)
    {
        return $query->where('id', $id);
    }

    public function meal()
    {
        return $this->hasMany('App\Models\Meal', '_cookid', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function owner()
    {
        return $this->belongsTo('App\User');
    }
}
