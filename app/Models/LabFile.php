<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;

/**
 * @property $lab Lab
 * @property $name string
 */
class LabFile extends Model
{
    const STORE_DIR_NAME = 'lab';

    protected $guarded = [];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function getRootStoreFileName()
    {
        $rootStorage = Config::get('filesystems.disks.local.root');

        return $rootStorage . '/' . $this->getStoreFileName();
    }

    public function getStoreFileName()
    {
        return self::getStoreDirName($this->lab->id) . '/' . $this->name;
    }

    static public function getStoreDirName($string = '')
    {
        return self::STORE_DIR_NAME . '/' . $string ?: '';
    }

}