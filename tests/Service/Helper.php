<?php

namespace Test\Service;


class Helper
{
    /**
     * Note: 将二维数组的某列时间转移为时间戳
     * @param $arr array 二维数组
     * @param $field string 要转移列的键名
     * @return array
     * @Author: Wong
     * @Time: 2022/8/16 23:25
     */
    static function ArrConvertToTime($arr, $field = 'create_at') {

        foreach ($arr as &$value) {
            $value[$field] = strtotime($value[$field]);
        }
        return $arr;
    }
}