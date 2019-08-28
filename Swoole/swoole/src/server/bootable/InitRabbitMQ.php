<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/14 13:02
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\server\bootable;


use mapgoo\base\Application;
use mapgoo\base\Config;
use mapgoo\connect\Amqp;

class InitRabbitMQ implements BootableInterface
{
    public function bootstrap()
    {
        $mq = Config::get('mq');
        if(!empty($mq)){
            Application::$amqp = Amqp::getInstance();
        }
    }
}