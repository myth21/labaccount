<?php

namespace App\Policies;

use App\User;
use App\Models\Lab;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function index(User $user, Lab $model = null)
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can create or store Lab model.
     *
     * @param  \App\User $user
     * @param  \App\Models\Lab $model
     * @return mixed
     */
    public function create(User $user, Lab $model = null)
    {
        return $user->isTeacher();
    }

    public function store(User $user, Lab $model = null)
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can edit or update the models Lab.
     *
     * @param  \App\User $user
     * @param  \App\Models\Lab $model
     * @return mixed
     */
    public function edit(User $user, Lab $model)
    {
        return $user->isTeacher();
    }

    public function update(User $user, Lab $model)
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can delete the models Lab.
     *
     * @param  \App\User $user
     * @param  \App\Models\Lab $model
     * @return mixed
     */
    public function destroy(User $user, Lab $model) // for contoller method
    {
        return $user->isTeacher();
    }

}
