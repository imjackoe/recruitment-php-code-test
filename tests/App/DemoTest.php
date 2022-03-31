<?php

namespace Test\App;

use App\Service\AppLogger;
use HttpRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductHandlerTest
 */
class DemoTest extends TestCase
{

    public function testGetUserInfo()
    {
        $demo = new \Demo(AppLogger::getInstance('log4php'), new HttpRequest());
        $data = $demo->get_user_info();
        print_r($data);
    }

}