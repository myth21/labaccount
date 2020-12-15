<?php

namespace App\Policies;

use App\User;
use App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
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
     * @param  \App\Models\Course  $model
     * @return mixed
     */
    public function edit(User $user, Course $model)
    {

    }

    public function update(User $user, Course $model)
    {

    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Course  $model
     * @return mixed
     */
    public function destroy(User $user, Course $model)
    {

    }

}
