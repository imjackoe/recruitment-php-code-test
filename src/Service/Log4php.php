<?php

namespace App\Service;

use Logger;

class Log4php implements ILogger
{
    private static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): Log4php
    {
        if (null == self::$instance) {
            self::$instance = new Log4php();
        }

        return self::$instance;
    }

    public function info(string $message)
    {
        Logger::getLogger('Log')->info($message);
    }

    public function debug(string $message)
    {
        Logger::getLogger('Log')->debug($message);
    }

    public function error(string $message)
    {
        Logger::getLogger('Log')->error($message);
    }
}
