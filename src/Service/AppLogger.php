<?php

namespace App\Service;

abstract class AppLogger
{
    /**
     * 打印信息日志
     * @param $message
     * @return mixed
     */
    abstract function info($message = '');

    /**
     * 调试信息
     * @param $message
     * @return mixed
     */
    abstract function debug($message = '');

    /**
     * 错误信息
     * @param $message
     * @return mixed
     */
    abstract function error($message = '');


    public static function getInstance($className)
    {
        $className = ucfirst(trim($className));
        $classFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'interface' . DIRECTORY_SEPARATOR . $className . ".php";
        if (!file_exists($classFile))
            exit("Logger file $classFile is not exist");
        include_once($classFile);

        $cl = new \ReflectionClass($className);
        return $cl->newInstance();
    }
}