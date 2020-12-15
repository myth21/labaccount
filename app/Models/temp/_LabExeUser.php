<?php

namespace App\Models;

use App\Models\LabExeUserFile;
use App\User;

class _LabExeUser extends Model
{
    const DEFAULT_STATUS = 'Выполнение';
    const DONE_STATUS = 'Сдано';

    public $timestamps = true;

    protected $guarded = [];

    public function labExeUserFiles()
    {
        return $this->hasMany(LabExeUserFile::class);
    }

//    public function labExeUserResult()
//    {
//        return $this->hasOne(LabExeUserResult::class);
//    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    */

//    public function getStatus()
//    {
//        return $this->status ?: self::DEFAULT_STATUS;
//        return $this->labExeUserResult ? $this->labExeUserResult->status : \App\Models\LabExeUserResult::DEFAULT_STATUS;
//    }

    public function getStatusList()
    {
        $statuses = Model::getEnums($this->getTable(), 'status');
        if (Auth()->user()->isStudent()) {
            unset($statuses[self::DONE_STATUS]);
        }

        return $statuses;
    }
}
