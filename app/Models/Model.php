<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    static public function getEnums($table, $field)
    {
        $result = DB::select('SHOW COLUMNS FROM '.$table.' WHERE Field = "'.$field.'"');
        $type = $result[0]->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        $enum = array_combine(array_values($enum), $enum);

        return $enum;
    }
}
