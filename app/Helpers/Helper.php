<?php

namespace App\Helpers;

class Helper
{
    static public function getAbsInt($value)
    {
        if (is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[$k] = self::getAbsInt($v);
            }
            return $out;
        }

        return abs((int)$value);
    }

    static public function getCamelCaseFromDot($value)
    {
        $value = ucwords(str_replace(['.', '_'], ' ', $value));
        $value = str_replace(' ', '', $value);
        $value = lcfirst($value);

        return $value;
    }

    static public function getUploadMaxFilesize()
    {
        if (is_numeric($postMaxSize = ini_get('upload_max_filesize'))) {
            return (int) $postMaxSize;
        }

        $metric = strtoupper(substr($postMaxSize, -1));
        $postMaxSize = (int) $postMaxSize;

        switch ($metric) {
            case 'K':
                return $postMaxSize * 1024;
            case 'M':
                return $postMaxSize * 1048576;
            case 'G':
                return $postMaxSize * 1073741824;
            default:
                return $postMaxSize;
        }
    }

    static public function getCkecked($currentKey, array $list)
    {
        return array_key_exists($currentKey, $list) ? 'checked=checked' : '';
    }
}