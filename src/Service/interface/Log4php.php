<?php


use App\Service\AppLogger;

class Log4Php extends AppLogger
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