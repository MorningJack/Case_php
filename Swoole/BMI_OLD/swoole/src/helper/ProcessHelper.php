<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 17:55
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\helper;


class ProcessHelper
{
    /**
     * 设置当前进程名称
     * @param string $title 名称
     * @return bool
     */
    public static function setProcessTitle(string $title)
    {
        if (PhpHelper::isMac()) {
            return false;
        }

        if (function_exists('swoole_set_process_name')) {
            @swoole_set_process_name($title);
        }
        return true;
    }
}