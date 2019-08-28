<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/14 17:11
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\helper;


use mapgoo\base\Application;
use mapgoo\base\Config;
use mapgoo\base\Register;
use mapgoo\resource\Communicator;

class IceHelper
{
    private static $_instance;
    /**
     * 初始化
     * IceHelper constructor.
     */
    private function __construct()
    {

    }

    /**
     * 返回实例
     */
    public static function getInstance()
    {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 调用ICE
     * @param string $name
     * @param string $action
     * @param string $message
     * @param array $option
     * @param string $namespace
     * @return bool|mixed
     */
    public function call(string $name, string $action, array $message, $option = [], $namespace = '\\app\\api\\ice')
    {
        if(isset($option['session'])){
            $alias = md5($option['session']);
        }else{
            $alias = $name;
        }
        $handle = Register::get($alias);
        if(!$handle){
            $ice = Config::get('ice.option');
            if(!empty($ice)){
                if(isset($ice[$name])){
                    Application::$communicator = Communicator::getInstance();
                    if(isset($option['session'])){
                        $session = $option['session'];
                    }else{
                        if(empty($ice[$name]['session']) || empty($ice[$name]['helper'])){
                            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: {$name} session 或 helper 或 import 未设置";
                            echo "\n";
                            return false;
                        }
                        $session = $ice[$name]['session'];
                    }
                    $object = Application::$communicator->getCommunicator()->stringToProxy($session);
                    try{
                        $handle = $ice[$name]['helper']::checkedCast($object);
                        Register::set($alias, $handle);
                    } catch (\Ice_LocalException $ex) {
                        echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: {$name} connect error :".print_r ($ex,true);
                        echo "\n";
                    }
                }
            }
            if(empty($handle)){
                return false;
            }
        }
        $class = $namespace . '\\' . ucfirst($name);
        return (new $class())->$action($handle, $message);
    }

    /**
     * 覆盖__clone()方法，禁止克隆
     */
    private function __clone()
    {

    }
}