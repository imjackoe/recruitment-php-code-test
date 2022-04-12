<?php
namespace Test\Service;

use App\Service\Logs\Log4php;
use App\Service\Logs\ThinkLog;
use PHPUnit\Framework\TestCase;
use App\Service\AppLogger;

/**
 * Class AppLoggerTest
 */
class AppLoggerTest extends TestCase
{
    /**
     * 构造函数
     *
     * @param string|null $name
     * @param array $data
     * @param $dataName
     */
    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        //注册log4php日志工具
        AppLogger::extend('log4php', new Log4php);

        //注册think-log日志工具
        AppLogger::extend('think-log', new ThinkLog('file', [
            'default'	=>	'file',
            'channels'	=>	[
                'file'	=>	[
                    'type'	=>	'file',
                    'path'	=>	'./logs/',
                ],
            ],
        ]));
    }

    /**
     * 测试输出日志
     *
     * @return void
     */
    public function testInfoLog()
    {
        $logger = new AppLogger('log4php');
        $logger->info('This is info log message');

        $logger = new AppLogger('think-log');
        $logger->info('This is info log message');
    }
}