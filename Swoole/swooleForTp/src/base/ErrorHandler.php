<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 20:58
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;


class ErrorHandler
{
    /**
     * 注册错误监听器
     */
    public function register()
    {
        ini_set('display_errors', false);
        set_exception_handler([$this, 'handlerException']);
        set_error_handler([$this, 'handlerError']);
        register_shutdown_function([$this, 'handlerFatalError']);
    }

    /**
     * 处理未捕获异常
     * @param \Throwable $exception
     */
    public function handlerException(\Throwable $exception)
    {
        $this->renderException($exception);
    }

    /**
     * 处理错误
     * @param string $code
     * @param string $message
     * @param string $file
     * @param int    $line
     */
    public function handlerError($code, $message, $file, $line)
    {
        $exception = new \ErrorException($message, $code, $code, $file, $line);
        $this->renderException($exception);
    }

    /**
     * 处理致命错误
     */
    public function handlerFatalError()
    {
        $error = error_get_last();
        if (!empty($error)) {
            $exception = new \ErrorException($error['message'], $error['type'], $error['type'], $error['file'], $error['line']);
            $this->renderException($exception);
        }
    }

    /**
     * 显示错误
     * @param \Throwable $exception
     * @throws \Throwable
     */
    public function renderException(\Throwable $exception)
    {
        throw $exception;
        return;
    }
}