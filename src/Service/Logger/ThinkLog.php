<?php

namespace App\Service\Logger;

use think\facade\Log;

class ThinkLog implements LoggerInterface
{

    private $logger;

    public function __construct()
    {
        // 定义配置
        Log::init([
            'default'	=>	'file',
            'channels'	=>	[
                'file'	=>	[
                    'type'	=>	'file',
                    'path'	=>	'./logs/',
                ],
            ],
        ]);

        $this->logger = Log::channel();
    }

    public function info($message = '')
    {
        $this->logger->info(strtoupper($message));
    }

    public function debug($message = '')
    {
        $this->logger->debug(strtoupper($message));
    }

    public function error($message = '')
    {
        $this->logger->error(strtoupper($message));
    }


}