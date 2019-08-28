<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/14 9:03
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\resource;


use mapgoo\base\Config;

class Communicator
{
    private static $_instance;
    //ice资源
    private $_communicator = null;
    /**
     * 初始化资源
     */
    private function __construct()
    {

    }

    /**
     * 覆盖__clone()方法，禁止克隆
     */
    private function __clone()
    {

    }

    /**
     * 返回实例
     * @return Communicator
     */
    public static function getInstance()
    {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 初始化资源
     */
    public function initialize()
    {
        $ice = Config::get('ice');
        $messageSizeMax = !empty($ice['messageSizeMax']) ? $ice['messageSizeMax'] : 0;
        $iceGrid = !empty($ice['iceGrid']) ? $ice['iceGrid'] : '';
        $initData = new \Ice_InitializationData;
        $initData->properties = Ice_createProperties();
        $initData->properties->setProperty('Ice.MessageSizeMax', $messageSizeMax);
        if($iceGrid){
            $initData->properties->setProperty('Ice.Default.Locator', $iceGrid);
        }
        $this->_communicator = Ice_initialize($initData);
    }

    /**
     * 获取ice资源
     * @return mixed
     */
    public function getCommunicator()
    {
        if(!$this->_communicator){
            $this->initialize();
        }
        return $this->_communicator;
    }

    /**
     * 销毁communicator资源
     */
    public function destructCommunicator()
    {
        if($this->_communicator){
            try {
                $this->_communicator->destroy();
                $this->_communicator = null;
            } catch(\Exception $ex) {
                echo $ex . "\n";
            }
        }
        return;
    }
}