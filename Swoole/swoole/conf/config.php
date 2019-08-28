<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 17:31
 * Email: 1183@mapgoo.net
 */
return [
    'server'  => [
        'pfile'      => '/tmp/swoole.pid',
        'pname'      => 'php-swoole',
        'autoReload' => true,
    ],
    'http'    => [
        'host'  => '0.0.0.0',
        'port'  => 10800,
        'model' => SWOOLE_PROCESS,
        'type'  => SWOOLE_SOCK_TCP,
    ],
    'setting' => [
        'worker_num'      => 4,
        'max_request'     => 100000,
        'daemonize'       => 0,
        'dispatch_mode'   => 2,
        'log_file'        => LOG_PATH . 'swoole.log',
        'task_worker_num' => 10,
        'http_parse_post' => false,
    ]
];