<?php

namespace App;

use App\Models\Course;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_ROLE = 'admin';
    const STUDENT_ROLE = 'student';
    const TEAHCER_ROLE = 'teacher';

    const STORE_DIR_NAME = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getCourses()
    {
        /** @var \Illuminate\Database\Eloquent\Builder $builder */
        $builder = $this->isTeacher() || $this->isStudent() ? $this->courses() : Course::orderBy('name', 'asc');
        /** @var Course[] $courses */
        $models = $builder->get()->all();

        return $models;
    }

    static public function getRoleDropdownList()
    {
        $dropdown = [
            self::STUDENT_ROLE => 'Студент',
            self::TEAHCER_ROLE => 'Преподаватель',
            self::ADMIN_ROLE => 'Админ',
        ];

        return $dropdown;
    }

    static public function getRoleFromDropdownList($role)
    {
        $roles = self::getRoleDropdownList();

        return $roles[$role];
    }

    public function isAdmin()
    {
        return $this->role == self::ADMIN_ROLE;
    }

    public function isStudent()
    {
        return $this->role == self::STUDENT_ROLE;
    }

    public function isTeacher()
    {
        return $this->role == self::TEAHCER_ROLE;
    }

    public function isAvailableCreate($forceAccess = null)
    {
        if ($forceAccess || $this->isAdmin() || $this->can('create')) {
            return true;
        }

        return false;
    }

}