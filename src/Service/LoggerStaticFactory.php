<?php

namespace App\Service;

final class LoggerStaticFactory
{
    const TYPE_LOG4PHP = 'log4php';

    const TYPE_THINKLOG = 'think-log';

    public static function factory(string $type): ILogger
    {
        if (self::TYPE_LOG4PHP == $type) {
            return Log4php::getInstance();
        }

        if (self::TYPE_THINKLOG == $type) {
            return ThinkLog::getInstance();
        }

        throw new \InvalidArgumentException('type error!');
    }
}
