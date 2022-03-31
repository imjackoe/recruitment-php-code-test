<?php


use App\Service\AppLogger;
use think\facade\Log;

class ThinkLog extends AppLogger
{

    function __construct()
    {
        Log::init([
            'default'	=>	'file',
            'channels'	=>	[
                'file'	=>	[
                    'type'	=>	'file',
                    'path'	=>	'./logs/',
                ],
            ],
        ]);
    }

    function info($message = '')
    {
        Log::info($message);
    }

    function debug($message = '')
    {
        Log::debug($message);

    }

    function error($message = '')
    {
        Log::error($message);
    }
}