<?php

namespace App\Models;

use App\User;

abstract class _CourseGroup extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
