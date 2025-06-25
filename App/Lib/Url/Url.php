<?php

namespace App\Lib\Url;

class Url
{
    private static array $segments = [];

    public static function parse(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $baseurl = "/pbr-ads-2025-1-p3-tidai-t1-8246101-pbr-ads-2025-1-p1-supermauro/src/backend/";
        $afterBase = str_replace($baseurl, "", $uri);
        self::$segments = explode('/', $afterBase);
    }

    public static function segment(int $index): ?string
    {
        self::parse();
        return self::$segments[$index] ?? null;
    }

    public static function all(): array
    {
        self::parse();
        return self::$segments;
    }
}
