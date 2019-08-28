<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 17:15
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\server\bootable;


class InitMbFunsEncoding implements BootableInterface
{
    public function bootstrap()
    {
        mb_internal_encoding("UTF-8");
    }
}