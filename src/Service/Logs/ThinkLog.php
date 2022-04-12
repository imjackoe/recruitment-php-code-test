<?php
namespace App\Service\Logs;

use App\Service\LoggerInterface;
use think\LogManager;

/**
 * Think-log工具类
 *
 */
class ThinkLog implements LoggerInterface
{
    protected $logger;

    /**
     * 构造函数
     *
     * @param $channel
     * @param $config
     */
    public function __construct($channel='file', $config)
    {
        $logger = new LogManager();
        $logger->init($config);
        $this->logger   = $logger->channel($channel);
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
        $this->logger->info($this->toUpper($message));
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
        $this->logger->debug($this->toUpper($message));
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
        $this->logger->error($this->toUpper($message));
    }

    /**
     * 输出信息大写
     *
     * @param $message
     * @return string
     */
    protected function toUpper($message)
    {
        return strtoupper($message);
    }
}