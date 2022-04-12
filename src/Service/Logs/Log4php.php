<?php
namespace App\Service\Logs;

use App\Service\LoggerInterface;

/**
 * Log4php工具类
 *
 */
class Log4php implements LoggerInterface
{
    protected $logger;

    /**
     * 构造函数
     *
     * @param $name 日志通道
     */
    public function __construct($name = 'Log')
    {
        $this->logger   = \Logger::getLogger($name);
    }

    /**
     * 输出INFO类型日志
     *
     * @param $message
     * @return mixed|void
     */
    public function info($message = '')
    {
        // TODO: Implement info() method.
        $this->logger->info($message);
    }

    /**
     * 输出DEBUG类型日志
     *
     * @param $message
     * @return mixed|void
     */
    public function debug($message = '')
    {
        // TODO: Implement debug() method.
        $this->logger->debug($message);
    }

    /**
     * 输出ERROR类型日志
     *
     * @param $message
     * @return mixed|void
     */
    public function error($message = '')
    {
        // TODO: Implement error() method.
        $this->logger->error($message);
    }
}