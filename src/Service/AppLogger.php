<?php

namespace App\Service;
use think\LogManager;


class AppLogger
{
    const TYPE_LOG4PHP = 'log4php';
    const TYPE_THINK_LOG = 'think-log';

    private $logger;
    private $type;

    public function __construct($type = self::TYPE_LOG4PHP)
    {
        $this->type = $type;
        if ($type == self::TYPE_LOG4PHP) {
            $this->logger = \Logger::getLogger("Log");
        }elseif ($type == self::TYPE_THINK_LOG){
            $this->logger = new LogManager();;
        }
    }

    public function info($message = '')
    {
        $this->logger->info($this->msgToUpper($message));
    }

    public function debug($message = '')
    {
        $this->logger->debug($this->msgToUpper($message));
    }

    public function error($message = '')
    {
        $this->logger->error($this->msgToUpper($message));
    }

    private function msgToUpper($message){
        if($this->type == self::TYPE_THINK_LOG){
            $message = strtoupper($message);
        }
        return $message;
    }
}