<?php

namespace app\core;

class Config
{

    private static array $_config;

    public static function get(string $key): mixed
    {
        if (empty(self::$_config)) {
            self::$_config = require '../config.php';
        }
        return(self::$_config[$key] ?? null);
    }
}