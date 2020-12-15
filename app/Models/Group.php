<?php

namespace App\Models;

/**
 * @property $name string
 * @property \App\Models\Student $students
 */
class Group extends Model
{
    protected $guarded = [];

    static public function getList()
    {
        $dropdown = [];

        $models = Group::all();
        foreach ($models as $model) {
            $dropdown[$model->id] = $model->name;
        }

        return $dropdown;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
