<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 17:41
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\server;


interface ServerInterface
{
    /**
     * 启动
     */
    public function start();

    /**
     * 停止
     * @return bool
     */
    public function stop();

    /**
     * 重载
     * @param bool $onlyTask    是否只reload任务
     */
    public function reload($onlyTask = false);

    /**
     * 是否已经运行
     * @return bool
     */
    public function isRunning();

    /**
     * 获取server
     * @return AbstractServer
     */
    public function getServer();

    /**
     * http配置
     * @return array
     */
    public function getHttpSetting();

    /**
     * server配置
     * @return array
     */
    public function getServerSetting();

    /**
     * 设置守护进程
     */
    public function setDaemonize();
}