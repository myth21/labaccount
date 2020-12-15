<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;

class _LabExeUserFile extends Model
{
    const STORE_DIR_NAME = 'labexeuser';

    protected $guarded = [];

    public function labExeUser()
    {
        return $this->belongsTo(LabExeUser::class);
    }

    public function labStudent()
    {
        return $this->belongsTo(LabStudent::class);
    }

    public function getRootStoreFileName()
    {
        $rootStorage = Config::get('filesystems.disks.local.root');

        return $rootStorage . '/' . $this->getStoreFileName($this->labStudent);
    }

    public function getStoreFileName(LabStudent $model)
    {
        return self::getStoreDirName($model) . '/' . $this->hash_name;
    }

    static public function getStoreDirName(LabStudent $model)
    {
        return self::STORE_DIR_NAME . '/' . $model->id . '/' . $model->user_id;
    }

}
