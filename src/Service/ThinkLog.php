<?php

namespace App\Service;

use think\facade\Log;

class ThinkLog implements ILogger
{
    private static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): ThinkLog
    {
        if (null == self::$instance) {
            self::$instance = new ThinkLog();
        }
        Log::init([
            'default'  => 'file',
            'channels' => [
                'file' => [
                    'type' => 'file',
                    'path' => './logs/',
                ],
            ],
        ]);

        return self::$instance;
    }

    public function info(string $message)
    {
        Log::info(strtoupper($message));
    }

    public function debug(string $message)
    {
        Log::debug(strtoupper($message));
    }

    public function error(string $message)
    {
        Log::error(($message));
    }
}
