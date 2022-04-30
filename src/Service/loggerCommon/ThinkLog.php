<?php

namespace App\Service\loggerCommon;

use App\Service\AppLogger;
use think\facade\Log;

class ThinkLog
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
        Log::info(strtoupper($message));
    }

    function debug($message = '')
    {
        Log::debug(strtoupper($message));

    }

    function error($message = '')
    {
        Log::error(strtoupper($message));
    }
}
