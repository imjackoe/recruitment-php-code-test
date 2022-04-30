<?php

namespace App\Service\loggerCommon;

class Log4Php
{

    /**
     * @var \Logger
     */
    private $logger;

    function __construct()
    {
        $this->logger = \Logger::getLogger("Log");
    }

    function info($message = '')
    {
        $this->logger->info($message);
    }

    function debug($message = '')
    {
        $this->logger->debug($message);

    }

    function error($message = '')
    {
        $this->logger->error($message);

    }
}
