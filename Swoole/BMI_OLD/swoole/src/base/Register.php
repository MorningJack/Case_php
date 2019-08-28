<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/14 10:30
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;


class Register
{
    //用于储存实例
    public static $objects;

    /**
     * 将实例插入注册树中
     * @param $alias 对象别名-注册树中的名称
     * @param $object 对象实例
     */
    public static function set($alias, $object)
    {
        self::$objects[$alias] = $object;
    }

    /**
     * 从注册树中读取实例
     * @param $alias 对象别名-注册树中的名称
     * @return mixed 返回的对象实例
     */
    public static function get($alias)
    {
        return isset(self::$objects[$alias]) ? self::$objects[$alias] : null;
    }

    /**
     * 销毁注册树中的实例
     * @param $alias 对象别名-注册树中的名称
     */
    public static function _unset($alias)
    {
        unset(self::$objects[$alias]);
    }
}