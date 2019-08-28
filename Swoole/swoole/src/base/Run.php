<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 20:51
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;


class Run
{
    //@var \Swoole\Http\Request
    private $request = null;

    //@var \Swoole\Http\Response
    private $response = null;

    /**
     * request请求处理
     * @param \Swoole\Http\Request  $request
     * @param \Swoole\Http\Response $response
     * @return bool
     */
    public function doRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        // chrome两次请求bug修复
        if (isset($request->server['request_uri']) && $request->server['request_uri'] === '/favicon.ico') {
            $response->end('favicon.ico');
            return false;
        }

        // 初始化request和response
        $this->request = new \mapgoo\http\Request($request);
        $this->response = new \mapgoo\http\Response($response);

        // 运行controller
        $this->runController();
    }

    /**
     * 运行控制器
     * @throws \Exception
     */
    public function runController(string $layer = 'controller')
    {
        // 解析URI和method
        $uri = $this->request->getPathInfo();
        if(!$uri){
            $this->response->response(200, 'mapgoo')->send();
            return;
        }

        $result = Route::check($this->request, $uri);

        // 路由无效 解析模块/控制器/操作
        if (false === $result){
            $result = Route::parseUrl($uri);
            if(false === $result){
                $this->response->response(404, 'invalid request:' . $uri)->send();
                return;
            }
        }

        // 记录当前调度信息
        $this->request->dispatch($result);

        $module    = !empty($result['module']) ? strtolower(array_shift($result['module'])) : '';
        $available = false;
        if (is_dir(APP_PATH . $module)) {
            $available = true;
        }

        // 模块初始化
        if ($module && $available) {
            // 初始化模块
            $this->request->module($module);
        } else {
            $this->response->response(404, 'module not exists:' . $module)->send();
            return;
        }

        // 获取控制器名
        $controller = !empty($result['module']) ? ucfirst(array_shift($result['module'])) : '';

        // 获取操作名
        $actionName = !empty($result['module']) ? array_shift($result['module']) : '';

        $this->request->controller($controller);
        $this->request->action($actionName);

        $class = Application::$namespace . '\\' .
            ($module ? $module . '\\' : '') .
            $layer . '\\' . $controller;
        if (!class_exists($class)) {
            $this->response->response(404, 'controller not exists:' . $class)->send();
            return;
        }

        $instance = new $class();

        if (is_callable([$instance, $actionName])) {
            $instance->$actionName($this->request, $this->response);
        } else {
            // 操作不存在
            $this->response->response(404, 'method not exists:' . get_class($instance) . '->' . $actionName . '()')->send();
            return;
        }
    }
}