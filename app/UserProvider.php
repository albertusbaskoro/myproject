<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProvider extends Model
{
    protected $table = 'user_provider';

	protected $visible = [
		'id', 'user_id', 'provider', 'provider_id'
	];
	public $timestamps = false;

	public function scopeTitleScope($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
