<?php

namespace App\Observers;

use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  User  $user
     * @return void
     */
    public function creating(User $user)
    {
        // $user->_id = Uuid::uuid4()->toString();
    }
    
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}
