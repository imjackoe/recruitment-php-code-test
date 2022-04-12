<?php
namespace App\Service;
/**
 * 日志工具接口
 *
 */
interface LoggerInterface
{
    /**
     * 输出INFO类型日志
     *
     * @param $message
     * @return mixed
     */
    public function info($message = '');

    /**
     * 输出DEBUG类型日志
     *
     * @param $message
     * @return mixed
     */
    public function debug($message = '');

    /**
     * 输出ERROR类型日志
     *
     * @param $message
     * @return mixed
     */
    public function error($message = '');
}