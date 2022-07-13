<?php

namespace App\Service;

use think\LogManager;

class ThinkLogger extends LoggerInterface
{
    private $logger;

    public function __construct()
    {
        $this->logger = new LogManager();
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