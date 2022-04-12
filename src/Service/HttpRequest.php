<?php

namespace App\Service;

/**
 * Http请求类
 *
 */
class HttpRequest
{
    /**
     * 发送GET请求
     *
     * @param $url
     * @return bool|string
     */
    public function get($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}