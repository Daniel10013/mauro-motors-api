<?php

namespace App\Lib\Environment;

class EnvData
{
    static function get(string $dataKey): string {
        $envFile = __DIR__ . '../../../.env';

        if (file_exists($envFile)) {
            $envData = parse_ini_file($envFile);
            if (array_key_exists($dataKey, $envData)) {
                return $envData[$dataKey];
            }
        }

        $envValue = getenv($dataKey);
        if ($envValue !== false) {
            return $envValue;
        }

        return '';
    }
}
