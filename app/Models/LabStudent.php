<?php

namespace App\Models;

use App\User;

/**
 * @property $student json
 */
class LabStudent extends Model
{
    public $timestamps = true;

    protected $guarded = [];
    protected $table = 'lab_student';

    public function labStudentExes()
    {
        return $this->hasMany(LabStudentExe::class);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStudentList()
    {
        $list = [];

        if (is_null($this->student)) {
            return $list;
        }

        $stdStudent = json_decode($this->student);

        $students = Student::whereIn('id', $stdStudent->ids)->get();
        foreach ($students as $student) {
            $list[$student->id] = $student->name;
        }

        return $list;
    }

    public function getStudentIds()
    {
        $list = $this->getStudentList();

        return array_keys($list);
    }

}
