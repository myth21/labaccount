<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {

    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

    }

    public function store(User $user)
    {

    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function edit(User $user, User $model)
    {

    }

    public function update(User $user, User $model)
    {

    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $user, User $model)
    {

    }

}
