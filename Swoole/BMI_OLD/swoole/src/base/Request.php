<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 20:31
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;


class Request
{
    //Swoole\Http\Request Swoole request对象
    protected $request;

    //@var array 请求headers
    protected $headers = [];

    //@var array 请求server
    protected $server = [];

    //@var array 请求get参数
    protected $get = [];

    //@var array 请求post参数
    protected $post = [];

    //@var array 请求cookie
    protected $cookie = [];

    //@var array 请求raw
    protected $raw = [];

    //@var array 请求上传文件集合
    protected $files = [];

    //@var array 路由信息
    protected $routeInfo = [];

    //@var array 调度信息
    protected $dispatch = [];

    //string 模块
    private $module = null;

    //string 控制器
    private $controller = null;

    //string 操作方法
    private $action = null;

    /**
     * Request constructor.
     * @param \Swoole\Http\Request $request
     */
    public function __construct(\Swoole\Http\Request $request)
    {
        $this->request = $request;
        $this->get = $request->get ?? [];
        $this->post = $request->post ?? [];
        $this->raw = $request->rawContent() ? json_decode($request->rawContent(), true, 512, JSON_BIGINT_AS_STRING) : [];
        $this->headers = $request->header ?? [];
        $this->server = $request->server ?? [];
        $this->cookie = $request->cookie ?? [];
        $this->files = $request->files ?? [];
    }

    /**
     * 请求方法
     * @return string
     */
    public function getMethod(): string
    {
        return $this->server['request_method'];
    }

    /**
     * 从GET/POST中获取一个参数，
     * @param string $name    参数名称
     * @param mixed  $default 默认值
     * @return mixed
     */
    public function getParameter(string $name, $default = null)
    {
        $params = $this->getParameters();

        if (isset($params[$name])) {
            return $params[$name];
        }

        return $default;
    }

    /**
     * 请求参数，等同$_REQUEST
     * @return array
     */
    public function getParameters(): array
    {
        return array_merge($this->get, $this->post);
    }

    /**
     * 设置或者获取当前请求的调度信息
     * @access public
     * @param array  $dispatch 调度信息
     * @return array
     */
    public function dispatch($dispatch = null)
    {
        if (!is_null($dispatch)) {
            $this->dispatch = $dispatch;
        }
        return $this->dispatch;
    }

    /**
     * GET参数，等同$_GET
     * @param mixed $name
     * @param mixed $default
     * @return mixed
     */
    public function getQuery($name = null, $default = null)
    {
        if ($name === null) {
            return $this->get;
        }

        return $this->get[$name] ?? $default;
    }

    /**
     * GET参数，等同$_GET
     * @return array
     */
    public function getGetParameters()
    {
        return $this->get;
    }

    /**
     * GET参数，等同$_GET
     * @param string $name
     * @param mixed  $default
     * @return array
     */
    public function getGetParameter($name, $default = null)
    {
        return $this->get[$name] ?? $default;
    }

    /**
     * POST参数，等同$_POST
     * @param mixed $name
     * @param mixed $default
     * @return array
     */
    public function getPost($name = null, $default = null)
    {
        if ($name === null) {
            return $this->post;
        }

        return $this->post[$name] ?? $default;
    }

    /**
     * POST参数，等同$_POST
     * @return array
     */
    public function getPostParameters()
    {
        return $this->post;
    }

    /**
     * POST参数，等同$_POST
     * @param string $name
     * @param mixed  $default
     * @return array
     */
    public function getPostParameter($name, $default = null)
    {
        return $this->post[$name] ?? $default;
    }

    /**
     * 获取原始的POST包体，用于非application/x-www-form-urlencoded格式的Http POST请求
     * @return array|string
     */
    public function getRawParameters()
    {
        return $this->raw;
    }

    /**
     * 获取原始的POST参数
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function getRawParameter($name, $default = null)
    {
        return $this->raw[$name] ?? $default;
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return $this->isXhr();
    }

    /**
     * Is this an XHR request?
     * Note: This method is not part of the PSR-7 standard.
     * @return bool
     */
    public function isXhr()
    {
        return $this->getHeader('X-Requested-With') === 'XMLHttpRequest';
    }

    public function getCharacterEncoding(): string
    {
    }

    public function getContentLength(): int
    {
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->getHeader('Content-Type');
    }

    /**
     * 获取所有header
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * 获取header
     * @param string $key     KEY名称
     * @param string $default 默认值
     * @return string
     */
    public function getHeader(string $key, string $default = ''): string
    {
        $key = strtolower($key);
        return $this->headers[$key] ?? $default;
    }

    /**
     * 获取当前请求的路由信息
     * @access public
     * @param array $route 路由名称
     * @return array
     */
    public function routeInfo($route = [])
    {
        if (!empty($route)) {
            $this->routeInfo = $route;
        } else {
            return $this->routeInfo;
        }
    }

    /**
     * 设置或者获取当前的模块名
     * @access public
     * @param string $module 模块名
     * @return string|Request
     */
    public function module($module = null)
    {
        if (!is_null($module)) {
            $this->module = $module;
            return $this;
        } else {
            return $this->module ?? '';
        }
    }

    /**
     * 设置或者获取当前的控制器名
     * @access public
     * @param string $controller 控制器名
     * @return string|Request
     */
    public function controller($controller = null)
    {
        if (!is_null($controller)) {
            $this->controller = $controller;
            return $this;
        } else {
            return $this->controller ?? '';
        }
    }

    /**
     * 设置或者获取当前的操作名
     * @access public
     * @param string $action 操作名
     * @return string|Request
     */
    public function action($action = null)
    {
        if (!is_null($action)) {
            $this->action = $action;
            return $this;
        } else {
            return $this->action ?? '';
        }
    }
}