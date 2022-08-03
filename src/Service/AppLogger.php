<?php

namespace App\Service;

class AppLogger
{
    const TYPE_LOG4PHP = 'log4php';
    const TYPE_THINKLOG = 'thinklog';

    private $logger;

    public function __construct($type = self::TYPE_LOG4PHP)
    {
        if ($type == self::TYPE_LOG4PHP) {
            $this->logger = new Log4Php();
        } elseif ($type == self::TYPE_THINKLOG)  {
            $this->logger = new ThinkLogger();
        }
        return $this->logger;
    }
}