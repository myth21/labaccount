<?php

namespace App\Policies;

use App\User;
use App\Models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models group.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create models groups.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {

    }

    public function store(User $user)
    {

    }

    /**
     * Determine whether the user can update the models group.
     *
     * @param  \App\User $user
     * @param  \App\Models\Group $model
     * @return mixed
     */
    public function edit(User $user, Group $model)
    {

    }

    public function update(User $user, Group $model)
    {

    }

    /**
     * Determine whether the user can delete the models group.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Group $model
     * @return mixed
     */
    public function destroy(User $user, Group $model)
    {

    }

}
