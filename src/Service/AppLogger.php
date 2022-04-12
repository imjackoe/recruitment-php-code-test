<?php
namespace App\Service;

/**
 * 日志处理类
 *
 */
class AppLogger
{
    /**
     * 保存所有注册的日志工具
     *
     * @var array
     */
    static protected $drivers   = [];
    /**
     * 日志工具
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * 构造函数，指定需要实例化的工具
     *
     * @param $name
     * @throws \Exception
     */
    public function __construct($name = null)
    {
        //如果没有配置，默认取第一个工具
        if ($name === null && !empty(self::$drivers)) {
            $name   = key(self::$drivers);
        }

        if (!isset(self::$drivers[$name])) {
            throw new \Exception("指定的日志工具不存在，请确定是否已经注册过该工具");
        }

        $this->logger   = self::$drivers[$name];
    }

    /**
     * 注册扩展日志工具
     *
     * @param string $name
     * @param LoggerInterface $driver
     * @return void
     */
    public static function extend(string $name, LoggerInterface $driver)
    {
        self::$drivers[$name]   = $driver;
    }

    /**
     * 输出INFO类型日志
     *
     * @param $message
     * @return void
     */
    public function info($message = '')
    {
        $this->logger->info($message);
    }

    /**
     * 输出DEBUG类型日志
     *
     * @param $message
     * @return void
     */
    public function debug($message = '')
    {
        $this->logger->debug($message);
    }

    /**
     * 输出ERROR类型日志
     *
     * @param $message
     * @return void
     */
    public function error($message = '')
    {
        $this->logger->error($message);
    }
}