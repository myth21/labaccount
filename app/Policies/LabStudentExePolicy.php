<?php

namespace App\Policies;

use App\User;
use App\Models\LabStudentExe;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabStudentExePolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models LabStudentExe.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LabStudentExe  $model
     * @return mixed
     */
    public function index(User $user, LabStudentExe $models)
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

    public function store(User $user)
    {
        return true;
    }

    public function add(User $user, LabStudentExe $model = null)
    {
        return $user->isTeacher() || $user->isStudent() && $model->status != LabStudentExe::DONE_STATUS;
    }

    public function save(User $user, LabStudentExe $model = null)
    {
        return $user->isTeacher() || $user->isStudent() && $model->status != LabStudentExe::DONE_STATUS;
    }

    public function show(User $user, LabStudentExe $model)
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can update the models LabStudentExe.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LabStudentExe  $model
     * @return mixed
     */
    public function edit(User $user, LabStudentExe $model)
    {
        return $user->isTeacher()/* || $user->isStudent() && $model->status != LabStudentExe::DONE_STATUS*/;
    }

    public function update(User $user, LabStudentExe $model)
    {
        return $user->isTeacher()/* || $user->isStudent() && $model->status != LabStudentExe::DONE_STATUS*/;
    }

    /**
     * Determine whether the user can delete the models LabStudentExe.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LabStudentExe  $model
     * @return mixed
     */
    public function destroy(User $user, LabStudentExe $model)
    {
        return $user->isTeacher();
    }

}
