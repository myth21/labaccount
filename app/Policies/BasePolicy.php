<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Call automatically on access checking
     *
     * @param $ability string, is action name, for example: update, delete...
     * @return bool
     */
    public function before($user, $ability)
    {
        /*
         * This action can be run from view, where access checking
         */
        /** @var \App\User $user */
        if ($user->isAdmin()) {
            return true;
        }
    }

}
