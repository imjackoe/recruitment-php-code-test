<?php

namespace App\Service;



class LoggerFactory
{
    public static function createAppLogger($type) {  
        switch ($type) {  
          case "log4php":  
             return  new Log4php();  
          case "think-log":  
             return  new ThinkLog(); 
         }
   }
}
interface LoggerBase
{
    public function info($message);
    public function debug($message);
    public function error($message);
}

class Log4php implements LoggerBase
{
    public function info($message = '')
    {
        \Logger::getLogger("Log")->info($message);
    }

    public function debug($message = '')
    {
        \Logger::getLogger("Log")->debug($message);
    }

    public function error($message = '')
    {
        \Logger::getLogger("Log")->error($message);
    }
}

class ThinkLog implements LoggerBase
{
    public function info($message = '')
    {
        \think\facade\Log::info($this->formatMessage($message));
    }

    public function debug($message = '')
    {
        \think\facade\Log::debug($this->formatMessage($message));
    }

    public function error($message = '')
    {
        \think\facade\Log::error($this->formatMessage($message));
    }

    private function formatMessage($message)
    {
        return strtoupper($message);
    }
}


class AppLogger 
{
    const TYPE_LOG4PHP = 'log4php';

    private $logger;

/*
    public function __construct($type = self::TYPE_LOG4PHP)
    {
        if ($type == self::TYPE_LOG4PHP) {
            $this->logger = \Logger::getLogger("Log");
        }
    }
*/
    public function __construct($type = self::TYPE_LOG4PHP)
    {
        $this->logger = LoggerFactory::createAppLogger($type);
    }
      
    public function info($message = '')
    {
        $this->logger->info($message);
    }

    public function debug($message = '')
    {
        $this->logger->debug($message);
    }

    public function error($message = '')
    {
        $this->logger->error($message);
    }
}