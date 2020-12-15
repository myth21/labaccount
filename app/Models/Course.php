<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * @property \App\Models\Group $groups
 */
class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];

    static public function getList()
    {
        $dropdown = [];

        $models = Auth::user()->getCourses();

        foreach ($models as $model) {
            $dropdown[$model->id] = $model->name;
        }

        return $dropdown;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function labs()
    {
        return $this->hasMany(Lab::class);
    }

}