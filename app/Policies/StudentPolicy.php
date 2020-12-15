<?php

namespace App\Policies;

use App\User;
use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models Student.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Student  $model
     * @return mixed
     */
    public function index(User $user, Student $models)
    {

    }

    /**
     * Determine whether the user can create model.
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
     * Determine whether the user can update the models Student.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Student  $model
     * @return mixed
     */
    public function edit(User $user, Student $model)
    {

    }

    public function update(User $user, Student $model)
    {

    }

    /**
     * Determine whether the user can delete the models Student.
     *
     * @param  \App\User $user
     * @param  \App\Models\Student $model
     * @return mixed
     */
    public function destroy(User $user, Student $model)
    {

    }

}
