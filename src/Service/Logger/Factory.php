<?php

namespace App\Service\Logger;

class Factory
{

    private static $classMap = [
        'log4php'   => Log4php::class,
        'think-log' => ThinkLog::class,
    ];

    public static function create($type)
    {
        if (!isset(self::$classMap[$type])) {
            throw new \Exception("[{$type}] Logger is not found!");
        }

        $class = self::$classMap[$type];
        return new $class();
    }


}