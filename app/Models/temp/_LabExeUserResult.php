<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\Config;

class _LabExeUserResult extends Model
{
//    const DEFAULT_STATUS = 'Выполнение';
//    const DONE_STATUS = 'Сдано';

    protected $guarded = [];

    public function labExeUser()
    {
        return $this->belongsTo(LabExeUser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    static public function getStatusList()
//    {
//        $statuses = Model::getEnums('lab_exe_user_results', 'status');
//        if (Auth()->user()->isStudent()) {
//            unset($statuses[self::DONE_STATUS]);
//        }
//
//        return $statuses;
//    }

    static public function getRateList()
    {
        return Model::getEnums('lab_exe_user_results', 'rate');
    }


}
