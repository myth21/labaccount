<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\Lab;

class _CourseLab extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function labExes()
    {
        return $this->hasMany(LabExe::class/*, 'local_key', 'parent_key'*/);
    }

    public function labFiles()
    {
        return $this->hasMany(LabFile::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    static public function getDropdownList($onModelId = null)
    {
        $dropdown = [];
        $models = Lab::all();
        foreach ($models as $model) {
            if (is_null($onModelId)) {
                $dropdown[$model->id] = $model->name;
            } elseif ($model->course_id == $onModelId) {
                $dropdown[$model->id] = $model->name;
            }
        }

        return $dropdown;
    }

}