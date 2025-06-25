<?php

namespace App\Lib\Environment;

class EnvData
{
    static function get(string $dataKey): string {
        $envData = parse_ini_file('.env');
        if(key_exists($dataKey, $envData)){
            return $envData[$dataKey];
        }
        return '';
    }
}
