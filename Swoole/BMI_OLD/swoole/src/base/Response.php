<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 20:34
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;


class Response
{
    //@var \Swoole\Http\Response
    protected $response;

    /**
     * 初始化响应请求
     * @param \Swoole\Http\Response $response
     */
    public function __construct(\Swoole\Http\Response $response)
    {
        $this->response = $response;
    }

    /**
     * 响应数据
     */
    public function send()
    {
    }
}