<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 20:37
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\http;


class Request extends \mapgoo\base\Request
{
    public $pathInfo;

    /**
     * 请求path
     * @return string
     */
    public function getPathInfo(): string
    {
        if(isset($this->server['path_info'])){
            $this->pathInfo = ltrim($this->server['path_info'], '/');
        }else{
            $pathInfo = !empty($this->server['request_uri']) ? explode('?', $this->server['request_uri']) : [];
            $this->pathInfo = !empty($pathInfo) ? ltrim(array_shift($pathInfo), '/') : '';
		}
		return $this->pathInfo;
    }


    /**
     * 请求参数串
     * @return string
     */
    public function getQueryString(): string
    {
        return $this->server['query_string'];
    }

    /**
     * 请求URI
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->server['request_uri'];
    }

    /**
     * remote ip
     * @return string
     */
    public function getRemoteIp()
    {
        return $this->server['remote_addr'];
    }

    /**
     * 获取所有cookes
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookie;
    }

    /**
     * 获取用户user agent
     * @param string $default 默认值
     * @return string
     */
    public function getUserAgent(string $default = '')
    {
        if (isset($this->headers['user-agent'])) {
            return $this->headers['user-agent'];
        }

        return $default;
    }
}