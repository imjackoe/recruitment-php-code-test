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

    }

    public function test_get_user_info_1() {
        $stub = $this->createStub(HttpRequest::class);
        $stub->method('get')
            ->willReturn('{"data":{"id": 1, "username": "hello world"},"error":0}');
        $logger = new AppLogger('log4php');
        $demo = new Demo($logger,$stub);
        $result = $demo->get_user_info();
        $this->assertArrayHasKey("username", $result);
        $this->assertArrayHasKey("id", $result);
    }

    public function test_get_user_info_2() {
        $stub = $this->createStub(HttpRequest::class);
        $stub->method('get')
            ->willReturn('{"status":404}');

        $observer = $this->createMock(AppLogger::class);
        $observer->expects($this->once())
            ->method('error')
            ->with($this->equalTo("fetch data error."));

        $demo = new Demo($observer,$stub);

        $result = $demo->get_user_info();
    }

    public function test_get_user_info_3() {
        $stub = $this->createStub(HttpRequest::class);
        $stub->method('get')
            ->willReturn('');
        $logger = new AppLogger('log4php');
        $demo = new Demo($logger,$stub);
        $result = $demo->get_user_info();
        $this->assertArrayHasKey("username", $result);
    }
}