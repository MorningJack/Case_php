<?php
/**
 * Rabbit队列助手函数
 * 2018-12-10 14:16
 * @author guoguo
 */
namespace app\common\helper;

/*
 * amqp协议操作类，可以访问rabbitMQ
 * 需先安装php_amqp扩展
 */
use think\Log;

class RabbitHelper{
    public $configs = array();
    //交换机名称
    public $exchangeName = '';
    //队列名称
    public $queueName = '';
    //路由名称
    public $routeKey = '';

    private $_conn = null;
    private $_exchange = null;
    private $_channel = null;

    public function __construct($configs = array(), $exchangeName = '', $queueName = '', $routeKey = '') {
        $this->setConfigs($configs);
        $this->exchangeName = $exchangeName;
        $this->queueName = $queueName;
        $this->routeKey = $routeKey;
    }

    private function setConfigs($configs) {
        $this->configs = $configs;
    }

    /*
     * 打开amqp连接
     */
    private function open() {
        if (!$this->_conn) {
            try {
              $this->_conn = new \AMQPConnection($this->configs);
              $this->_conn->connect();
              $this->initConnection();
            } catch (\AMQPConnectionException $ex) {
                Log::error('cannot connection rabbitmq');
                throw new \Exception('cannot connection rabbitmq', 500);
            }
        }
    }

    /*
     * rabbitmq连接不变
     * 重置交换机，队列，路由等配置
     */
    public function reset($exchangeName, $queueName, $routeKey) {
        $this->exchangeName = $exchangeName;
        $this->queueName = $queueName;
        $this->routeKey = $routeKey;
        $this->initConnection();
        return true;
    }

    /*
     * 初始化rabbit连接的相关配置
     */
    private function initConnection() {
        if (empty($this->exchangeName) || empty($this->queueName)) {
            Log::error('rabbitmq exchangeName or queueName is empty');
            throw new \Exception('rabbitmq exchangeName or queueName is empty',500);
        }
        $this->_channel = new \AMQPChannel($this->_conn);
        $this->_exchange = new \AMQPExchange($this->_channel);
        $this->_exchange->setName($this->exchangeName);
        return true;
    }

    public function close() {
        if ($this->_conn) {
          $this->_conn->disconnect();
        }
        return true;
    }

    public function __sleep() {
        $this->close();
        return array_keys(get_object_vars($this));
    }

    public function __destruct() {
        $this->close();
    }

    /*
     * 生产者发送消息
     */
    public function send($msg) {
        $this->open();
        return $this->_exchange->publish($msg, $this->routeKey);
    }
}
