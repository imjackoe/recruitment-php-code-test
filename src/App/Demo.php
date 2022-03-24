<?php
namespace App\App;

class Demo {
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
    function get_user_info() {
        $url = "http://some-api.com/user_info";
        $result = $this->_req->get($url);
        $result_arr = json_decode($result, true);
        if (in_array('error', $result_arr) && $result_arr['error'] == 0) {
            if (in_array('data', $result_arr)) {
                return $result_arr['data'];
            }
        } else {
            $this->_logger->error("fetch data error.");
        }
        return null;
    }

    function mock()
    {
        return ["error" => 0, "data" => ["id" => 1,'username' => 'hello world']];
    }
}
