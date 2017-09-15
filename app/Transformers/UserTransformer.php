<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
    	$user->address = ($user->address) ? $user->address : null;
        return $user->toArray();
    }
}
