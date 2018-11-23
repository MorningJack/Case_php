<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 20:38
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\http;


class Response extends \mapgoo\base\Response
{
    const FORMAT_HTML = 'html';
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    private $status = 200;
    private $charset = "utf-8";
    private $responseContent = "";
    private $format = self::FORMAT_JSON;

    /**
     * @var \Throwable 未知异常
     */
    private $exception = null;


    /**
     * 输出contentTypes集合
     * @var array
     */
    private $contentTypes = [
        self::FORMAT_XML => 'text/xml',
        self::FORMAT_HTML => 'text/html',
        self::FORMAT_JSON => 'application/json',
    ];

    /**
     * 显示数据
     */
    public function send()
    {
        $this->formatContentType();
        $this->response->status($this->status);
        $len = strlen($this->responseContent);
        $num = 100000;
        if($len > $num){
            for($i = 0 ; $i < $len ; $i+=$num){
                $this->response->write(mb_substr($this->responseContent, $i ,$num));
            }
            return;
        }else{
            $this->response->end($this->responseContent);
        }
        return;
    }

    /**
     * 添加header
     * @param string $name
     * @param string $value
     */
    public function addHeader(string $name, string $value)
    {
        $this->response->header($name, $value);
    }

    /**
     * 设置Http code
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * 设置格式json/html/xml...
     * @param string $format
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
    }

    /**
     * charset设置
     * @param string $charset
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;
    }

    /**
     * 获取异常
     * @return \Throwable 异常
     */
    public function getException(): \Throwable
    {
        return $this->exception;
    }

    /**
     * 设置异常
     * @param \Throwable $exception 初始化异常
     */
    public function setException(\Throwable $exception)
    {
        $this->exception = $exception;
    }

    /**
     * 设置返回内容
     * @param string $responseContent
     */
    public function setResponseContent(string $responseContent)
    {
        $this->responseContent = $responseContent;
    }

    /**
     * 添加cookie
     * @param string  $key
     * @param  string $value
     * @param int     $expire
     * @param string  $path
     * @param string  $domain
     */
    public function addCookie($key, $value, $expire = 0, $path = '/', $domain = '')
    {
        $this->response->cookie($key, $value, $expire, $path, $domain);
    }

    /**
     * 格式化contentType
     */
    private function formatContentType()
    {
        // contentType
        $contentType = $this->contentTypes[$this->format];
        $contentType .= ";charset=".$this->charset;

        $this->response->header('Content-Type', $contentType);
    }

    /**
     * 输出状态内容
     * @param int $code       状态码
     * @param string $reason  描述
     * @param string $messageId  消息ID
     * @param int $timestamp  时间戳
     * @param array $result   数据
     * @param bool $array     是否数组
     * @return $this
     */
    public function response($code = 200, $reason = '', $messageId = 0, $timestamp = 0, $result = [], $array = false)
    {
        $this->setStatus(200);
        if(!$timestamp){
            $timestamp = date('Y-m-d H:i:s');
        }
        if($array){
            $options = JSON_UNESCAPED_UNICODE;
        }else{
            $options = JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE;
        }
        $response = json_encode(['code' => $code, 'reason' => $reason, 'messageId' => $messageId, 'timestamp' => $timestamp, 'result' => $result], $options);
        $this->setResponseContent($response);
        return $this;
    }


}