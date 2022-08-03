<?php

namespace App\App;

use App\Util\HttpRequest;
use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    const URL = "http://some-api.com/user_info";
    private $_logger;
    private $_req;
    function __construct($logger, HttpRequest $req) {
        $this->_logger = $logger;
        $this->_req = $req;
    }
    function set_req(HttpRequest $req) {
        $this->_req = $req;
    }
    function foo() {
        return "bar";
    }
    function testGetUserInfo() {
        $result = $this->_req->get(self::URL);
        $this->assertJson();
        $result_arr = json_decode($result, true);
        $this->assertArraySubset(['error' => 0], $result_arr);
    }
}