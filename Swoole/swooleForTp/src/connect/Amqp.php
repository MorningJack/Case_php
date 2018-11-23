<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/11 21:12
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\connect;


use mapgoo\base\Config;

class Amqp
{
    private $connect = null;
    private $channel = null;
    private $exchange = null;

    private $error = null;

    private static $_instance;

    /**
     * 初始化MQ连接
     * Amqp constructor.
     */
    private function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $config = Config::get('mq');
        if($config){
            try{
                $this->connect = new \AMQPConnection($config);
                if($this->connect->pconnect()){
                    $this->channel = new \AMQPChannel($this->connect);
                    $this->exchange = new \AMQPExchange($this->channel);
                }else{
                    $this->error = 'Cannot connect to the broker';
                }
                return true;
            }catch (\AMQPConnectionException $e){
                $this->error = $e->getMessage();
            }catch (\AMQPChannelException $e){
                $this->error = $e->getMessage();
            }catch (\AMQPExchangeException $e){
                $this->error = $e->getMessage();
            }catch (\AMQPException $e){
                $this->error = $e->getMessage();
            }
            $this->disconnect();
        }
        return false;
    }

    /**
     * 重新连接
     */
    public function reConnect()
    {
        $res = false;
        if(!is_null($this->connect)){
            $res = $this->connect->preconnect();
        }
        return $res;
    }

    /**
     * 通道
     */
    public function reChannel()
    {
        if(!is_null($this->channel)){
            $this->channel = null;
        }
        try{
            $this->channel = new \AMQPExchange($this->connect);
            return true;
        }catch (\AMQPConnectionException $e){
            $this->error = $e->getMessage();
        }catch (\AMQPChannelException $e){
            $this->error = $e->getMessage();
        }catch (\AMQPExchangeException $e){
            $this->error = $e->getMessage();
        }catch (\AMQPException $e){
            $this->error = $e->getMessage();
        }
        return false;
    }

    /**
     * 交换机
     * @return bool
     */
    public function reExchange()
    {
        if(!is_null($this->exchange)){
            $this->exchange = null;
        }
        try{
            $this->exchange = new \AMQPExchange($this->channel);
            return true;
        }catch (\AMQPConnectionException $e){
            $this->error = $e->getMessage();
        }catch (\AMQPChannelException $e){
            $this->error = $e->getMessage();
        }catch (\AMQPExchangeException $e){
            $this->error = $e->getMessage();
        }catch (\AMQPException $e){
            $this->error = $e->getMessage();
        }
        return false;
    }
    /**
     * 返回实例
     * @return Amqp
     */
    public static function getInstance()
    {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 获取exchange
     * @return \AMQPExchange|null
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError() : string
    {
        return !is_null($this->error) ? $this->error : '';
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * 断开连接
     */
    public function disconnect()
    {
        if(!is_null($this->connect)){
            $this->connect->pdisconnect();
            $this->connect = null;
        }
        $this->channel = null;
        $this->exchange = null;
        $this->error = null;
    }

    /**
     * @param string $exchange 交换机名称
     * @param string $message  内容
     * @param array $option  配置
     * @param string $routing  路由
     * @param int $flags  One or more of AMQP_MANDATORY and AMQP_IMMEDIATE
     * @return mixed
     */
    public function publishMessage(string $exchange, string $message,array $option = [], string $routing = '', int $flags = AMQP_NOPARAM)
    {
        try {
            //if($this->exchange->setName($exchange)){
                $this->exchange->setName($exchange);
                $res = $this->exchange->publish($message, $routing, $flags, $option);
            //}else{
             //   $res = '队列无法找到';
           // }
            return $res;
        }catch (\AMQPConnectionException $e){
            $this->setError($e->getMessage());
            $this->reConnect();
        }catch (\AMQPChannelException $e){
            $this->setError($e->getMessage());
            $this->reChannel();
        }catch (\AMQPExchangeException $e){
            $this->setError($e->getMessage());
            $this->reExchange();
        }catch (\AMQPException $e){
            $this->disconnect();
            $this->setError($e->getMessage());
            $this->connect();
        }
        return $this->getError();
    }

    /**
     * 覆盖__clone()方法，禁止克隆
     */
    private function __clone()
    {

    }
}