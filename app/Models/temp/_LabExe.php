<?php

namespace App\Models;

use App\User;

class _LabExe extends Model
{
    const OPEN_STATUS = 'Выполнение';

    protected $guarded = [];

    public function init()
    {
        $this->status = self::OPEN_STATUS;
        return $this;
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    /*
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    */

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class); // via lab_exe_user -> pivot
    }

    public function getStatusList()
    {
        $statuses = Model::getEnums($this->getTable(), 'status');

        return $statuses;
    }

    public function isOpenStatus()
    {
        return $this->status == self::OPEN_STATUS;
    }
}
