<?php

namespace Test\App;

use PHPUnit\Framework\TestCase;
use App\Service\AppLogger;
use App\Service\loggerCommon\Log4Php;
use App\Service\loggerCommon\ThinkLog;

class LoggerTest extends TestCase {

    public function test_log4php() {
        // $observer = $this->createMock(Log4Php::class);
        // $observer->expects($this->once())
        //     ->method('info')
        //     ->with($this->equalTo("abcde"));
        // $this->attach($observer);

        $logger = new AppLogger('thinkLog');
        $logger->logger->info('abcde');
    }
}
