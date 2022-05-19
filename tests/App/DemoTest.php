<?php
/*
 * @Date         : 2022-03-02 14:49:25
 * @LastEditors  : Jack Zhou <jack@ks-it.co>
 * @LastEditTime : 2022-03-02 17:22:16
 * @Description  : 
 * @FilePath     : /recruitment-php-code-test/tests/App/DemoTest.php
 */

namespace Test\App;

use App\App\Demo;
use App\Service\AppLogger;
use App\Util\HttpRequest;
use PHPUnit\Framework\TestCase;


class DemoTest extends TestCase {
    
    public function test_foo() {
        $demo = $this->getDemo();
        $this->assertEquals('bar', $demo->foo());
    }

    public function test_get_user_info() {
        $demo = $this->getDemo();
        $userInfo = $demo->get_user_info();
        $this->assertIsArray($userInfo);
        $this->assertArrayHasKey('id', $userInfo);
        $this->assertArrayHasKey('username', $userInfo);
        $this->assertIsInt($userInfo['id']);
        $this->assertIsString($userInfo['username']);
    }

    protected function getDemo()
    {
        return new Demo(new AppLogger(), new HttpRequest());
    }

}