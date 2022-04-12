<?php
namespace App\App;

use App\Service\HttpRequest;

class Demo
{
    private $_logger;
    private $_req;

    /**
     * 构造函数
     * 注释太少，另外public、protected、private 很有必要补齐
     *
     * @param $logger
     * @param HttpRequest $req
     */
    public function __construct($logger, HttpRequest $req)
    {
        $this->_logger = $logger;
//        $this->set_req($req); //这里最好统一处理
        $this->_req = $req;
    }

    /**
     * 设置处理请求的类
     * 函数命名规则最好能全项目统一，要么统一驼峰，要么像文中这样
     *
     * @param HttpRequest $req
     * @return void
     */
    public function set_req(HttpRequest $req)
    {
        $this->_req = $req;
    }

    public function foo()
    {
        return "bar";
    }

    /**
     * 获取用户信息
     *
     * @return mixed|null
     */
    public function get_user_info()
    {
        $url = "http://some-api.com/user_info";
        $result = $this->_req->get($url);
        $result_arr = json_decode($result, true);
        //此处用isset更恰当，因为接口请求失败的时候，会报错
        if (isset($result_arr['error']) && $result_arr['error'] == 0) {
            if (isset($result_arr['data'])) {
//        if (in_array('error', $result_arr) && $result_arr['error'] == 0) {
//            if (in_array('data', $result_arr)) {
                //源代码此处少了一个;号
                return $result_arr['data'];
            }
        } else {
            $this->_logger->error("fetch data error.");
        }
        return null;
    }
}
