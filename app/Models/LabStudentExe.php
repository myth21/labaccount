<?php

namespace App\Models;

/**
 * @property $id int
 * @property $user_id int
 * @property $status string
 * @property \App\Models\LabStudent $labStudent
 */
class LabStudentExe extends Model
{
    const CHECK_STATUS = 'Проверить';
    const FAIL_STATUS = 'НеСдано';
    const DONE_STATUS = 'Сдано';

    public $timestamps = true;
    protected $guarded = [];

    public function labStudent()
    {
        return $this->belongsTo(LabStudent::class);
    }

    public function labStudentExeFiles()
    {
        return $this->hasMany(LabStudentExeFile::class);
    }

    public function getStatusList()
    {
        $statuses = Model::getEnums($this->getTable(), 'status');
        /** @var \App\User $user */
        $user = Auth()->user();
        if ($user->isStudent()) {
            unset($statuses[LabStudentExe::FAIL_STATUS]);
            unset($statuses[LabStudentExe::DONE_STATUS]);
        }

        return $statuses;
    }

    public function isStatus($status)
    {
        return $this->status == $status;
    }

    public function getStatusClassName()
    {
        if ($this->status == self::CHECK_STATUS) {
            return ' table-warning';
        }

        if ($this->status == self::DONE_STATUS) {
            return ' table-success';
        }

        if ($this->status == self::FAIL_STATUS) {
            return ' table-danger';
        }

        return '';
    }

    public function getLabStudentIds()
    {
        return $this->labStudent ? $this->labStudent->getStudentIds() : [];
    }

}
