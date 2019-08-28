<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 19:32
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;


class Application
{
    //控制台
    const CONSOLE = 0;

    //worker
    const WORKER = 1;

    //task
    const TASK = 2;

    //自定义进程
    const PROCESS = 3;

    private static $context = self::CONSOLE;

    //服务器对象
    public static $server;

    //app命名空间
    public static $namespace = 'app';

    //amqp对象
    public static $amqp;

    //ice对象
    public static $ice;

    //ice communicator资源
    public static $communicator;

    /**
     * 获取当前运行环境
     * @return int
     */
    public static function getContext(): int
    {
        return self::$context;
    }

    /**
     * 设置当前运行环境
     * @param int $context
     */
    public static function setContext(int $context)
    {
        self::$context = $context;
    }

    /**
     * 获取版本号
     * @return string
     */
    public static function version()
    {
        return MAPGOO_FRAME_VERSION;
    }
}