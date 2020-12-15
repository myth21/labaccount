<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;

/**
 * @property $name string
 * @property $hash_name string
 * @property \App\Models\LabStudentExe $labStudentExe
 */
class LabStudentExeFile extends Model
{
    const STORE_DIR_NAME = 'labstudentexe';

    protected $guarded = [];

    public function labStudentExe()
    {
        return $this->belongsTo(LabStudentExe::class);
    }

    public function getRootStoreFileName()
    {
        $rootStorage = Config::get('filesystems.disks.local.root');

        return $rootStorage . '/' . $this->getStoreFileName($this->labStudentExe);
    }

    public function getStoreFileName(LabStudentExe $model)
    {
        return self::getStoreDirName($model) . '/' . $this->hash_name;
    }

    static public function getStoreDirName(LabStudentExe $model)
    {
        return self::STORE_DIR_NAME . '/' . $model->id . '/' . $model->user_id;
    }

}
