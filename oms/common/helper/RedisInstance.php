<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\helper;

/**
 * Description of RedisInstance
 *
 * @author 99423
 */
class RedisInstance {
    
    private static $instance = null;
    private $_instance = null;

    private function __construct()
    {
        $this->_instance = new RedisHashHelper();
    }
    
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
             self::$instance = new self();
        }
        return self::$instance->_instance;
    }
    
    private function __clone(){
 
    }
}
