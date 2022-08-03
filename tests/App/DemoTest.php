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
use App\Util\HttpRequest;
use PHPUnit\Framework\TestCase;


class DemoTest extends TestCase {
    private $http;

    protected function setUp(): void
    {
        $this->http = new HttpRequest();
    }

    protected function tearDown(): void
    {
        $this->http = null;
    }

    public function test_foo() {
        $this->assertTrue(true);
    }

    public function test_get_user_info() {
        $response = $this->http->get(Demo::URL);
        $response = json_decode($response, true);
        if (empty($response) || !isset($response['error'])){
            $this->expectException(\InvalidArgumentException::class);
        }
        $this->assertEquals(0, $response['error']);
    }
}