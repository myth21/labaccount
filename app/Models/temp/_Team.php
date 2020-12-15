<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\Auth;

class _Team extends Model
{
    protected $guarded = [];

    static public function getList($lab_id = null)
    {
        $dropdown = [];

        /** @var \Illuminate\Database\Eloquent\Builder $builder */
        //$builder = Auth::user()->isTeacher() ? Auth::user()->courses() : Team::orderBy('name', 'asc');
        $builder = is_null($lab_id) ? Team::orderBy('id', 'asc') : Team::where('lab_id', $lab_id)->orderBy('id', 'asc');
        /** @var Course[] $courses */
        $models = $builder->get()->all();

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

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

}
