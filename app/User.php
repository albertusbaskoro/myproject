<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';

    protected $fillable = [
        'cognitoid',
        'phone',
        'email',
        'name',
        'imagepath',
        'profile',
        'ref_facebook',
        'ref_google',
        'ref_other',
        'created',
        'modified',
        'api_token',
        'facebook_id',
        'gplus_id',
        'verifyToken',
        'status',
        'address',
    ];

    protected $visible = [
        'id', 'cognitoid', 'phone', 'email', 'name', 'imagepath', 'profile', 'ref_facebook', 'ref_google', 'ref_other', 'created', 'modified', 'api_token', 'facebook_id', 'gplus_id', 'verifyToken', 'status', 'address',
    ];
    public $timestamps = false;

    public function scopeUser($query)
    {
        return $query->where('id', '16006');
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('id', 'asc');
    }

    public function address()
    {
        return $this->hasMany('App\Address', '_userid', 'id');
    }

}
