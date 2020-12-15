<?php

namespace App\Policies;

use App\User;
use App\Models\LabStudent;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabStudentPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models LabStudent.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LabStudent  $model
     * @return mixed
     */
    public function view(User $user, LabStudent $models)
    {
        return true;
    }

    /**
     * Determine whether the user can create models groups.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the models LabStudent.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LabStudent  $model
     * @return mixed
     */
    public function update(User $user, LabStudent $model)
    {
        return $user->isTeacher() /*|| $user->isStudent() && $model->status == LabStudent::DEFAULT_STATUS*/;
    }

    /**
     * Determine whether the user can delete the models LabStudent.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LabStudent  $model
     * @return mixed
     */
    public function destroy(User $user, LabStudent $model)
    {
        return $user->isTeacher();
    }

}
