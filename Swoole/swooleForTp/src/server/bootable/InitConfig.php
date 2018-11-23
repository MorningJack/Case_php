<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 17:16
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\server\bootable;


use mapgoo\base\Application;
use mapgoo\base\Config;
use mapgoo\server\AbstractServer;

class InitConfig implements BootableInterface
{
    public function bootstrap()
    {
        $server = Application::$server;
        if ($server instanceof AbstractServer) {
            $settings = Config::get();

            if (! isset($settings['http'])) {
                throw new \InvalidArgumentException("未配置http启动参数，settings=" . json_encode($settings));
            }

            if (! isset($settings['server'])) {
                throw new \InvalidArgumentException("未配置server启动参数，settings=" . json_encode($settings));
            }

            if (! isset($settings['setting'])) {
                throw new \InvalidArgumentException("未配置setting启动参数，settings=" . json_encode($settings));
            }

            $server->httpSetting = $settings['http'];
            $server->serverSetting = $settings['server'];
            $server->setting = $settings['setting'];
        }
    }
}