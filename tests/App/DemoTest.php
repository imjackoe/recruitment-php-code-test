<?php

namespace Test\App;

use PHPUnit\Framework\TestCase;
use App\Service\AppLogger;
use App\App\HttpRequest;
use App\App\Demo;

class DemoTest extends TestCase
{

    public function testGetUserInfo()
    {
    	$log = new AppLogger();
    	
       $req = new HttpRequest();
       $demo = new Demo($log, $req);
       // $result = $demo->get_user_info();
       $result = $demo->mock();

       $expect = ["error" => 0, "data" => ["id" => 1,'username' => 'hello world']];
        $this->assertEquals($expect, $result); 
    }
}