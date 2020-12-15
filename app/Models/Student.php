<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

/**
 * @property $id int
 * @property $group_id int
 * @property $name string
 */
class Student extends Model
{
    use Notifiable;

    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function labs()
    {
        return $this->belongsToMany(Lab::class);
    }

    static public function getListFromCourse(Course $course)
    {
        $list = [];

        /** @var \App\Models\Group $group */
        foreach ($course->groups as $group) {
            /** @var \App\Models\Student $student */
            foreach ($group->students as $student) {
                $list[$student->id] = $student->name;
            }
        }

        return $list;
    }

    static public function getUnitedListFromLab(Lab $lab)
    {
        $unitedList = [];

        $labStudents = LabStudent::where('lab_id', $lab->id)->get()->all();
        foreach ($labStudents as $labStudent) {
            /** @var \App\Models\LabStudent $labStudent */
            $unitedStudent = json_decode($labStudent->student);
            foreach ($unitedStudent->ids as $id) {
                $unitedList[$id] = (int)$id;
            }
        }

        return $unitedList;
    }

}
