<?php
namespace Test\App;

use App\App\Demo;
use App\Service\AppLogger;
use App\Service\HttpRequest;
use App\Service\Logs\Log4php;
use App\Service\Logs\ThinkLog;
use PHPUnit\Framework\TestCase;

/**
 * Class DemoTest
 *
 */
class DemoTest extends TestCase
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
     * 测试获取用户信息
     *
     * @return void
     */
    public function testGetUserInfo()
    {
        $demo   = new Demo(new AppLogger(), new HttpRequest());
        $info   = $demo->get_user_info();

        //判断是否为数组
        $this->assertIsArray($info);
        //判断id是否存在
        $this->assertArrayHasKey('id', $info);
        //判断username是否存在
        $this->assertArrayHasKey('username', $info);
    }
}