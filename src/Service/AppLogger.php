<?php

namespace App\Service;

use App\Service\loggerCommon\Log4Php;
use App\Service\loggerCommon\ThinkLog;

class AppLogger
{
    const TYPE_LOG4PHP = 'log4php';
    const TYPE_THINK_LOG = 'thinkLog';

    public $logger;

    public function __construct($type = self::TYPE_LOG4PHP)
    {
        $logArr = array(
            self::TYPE_LOG4PHP => new Log4Php(),
            self::TYPE_THINK_LOG => new ThinkLog(),
        );
        $this->logger = $logArr[$type] ?? $logArr[self::TYPE_LOG4PHP];
    }
}
