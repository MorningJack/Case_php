<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/14 12:58
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\server\bootable;


use mapgoo\base\Application;
use mapgoo\base\Config;
use mapgoo\base\Register;
use mapgoo\helper\IceHelper;
use mapgoo\resource\Communicator;

class InitIce implements BootableInterface
{
    public function bootstrap()
    {
        $ice = Config::get('ice');
        if(!empty($ice)){
            Application::$communicator = Communicator::getInstance();
            foreach ($ice['option'] as $item => $value){
                if(empty($value['session']) || empty($value['helper']) || empty($value['import'])){
                    echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: {$item} session 或 helper 或 import 未设置";
                    echo "\n";
                    continue;
                }
                $object = Application::$communicator->getCommunicator()->stringToProxy($value['session']);
                try{
                    Register::set($item, $value['helper']::checkedCast($object));
                } catch (\Ice_LocalException $ex) {
                    echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: {$item} connect error :".print_r ($ex,true);
                    echo "\n";
                }
            }
            Application::$ice = IceHelper::getInstance();
        }
    }
}