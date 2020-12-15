<?php

namespace App\Models;

/**
 * @property $id int
 */
class Lab extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function labStudents()
    {
        return $this->hasMany(LabStudent::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('id', 'user_id', 'status', 'comment', 'created_at', 'updated_at');
    }

    public function labFiles()
    {
        return $this->hasMany(LabFile::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    static public function getList($course_id = null)
    {
        $dropdown = [];
        $models = Lab::all();
        foreach ($models as $model) {
            if (is_null($course_id)) {
                $dropdown[$model->id] = $model->name;
            } elseif ($model->course_id == $course_id) {
                $dropdown[$model->id] = $model->name;
            }
        }

        return $dropdown;
    }

    static public function getUserList()
    {
        $dropdown = [];
        $courseIds = array_keys(Course::getList());
        $models = Lab::all();
        foreach ($models as $model) {
            if (in_array($model->course_id, $courseIds)) {
                $dropdown[$model->id] = $model->name;
            }
        }

        return $dropdown;
    }

}
