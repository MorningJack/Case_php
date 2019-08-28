<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/6/8
 * Time: 9:36
 * File: VerifyHelper.php
 */

namespace app\common\helper;

use think\cache\driver\Redis;

class RedisHashHelper extends Redis
{
    public function __construct($option = [])
    {
        parent::__construct($option = config('cache'));
        $this->select();
    }

    /**
     * NAME: HGetAll 获取在哈希表中指定 key 的所有字段和值
     * @param $key
     * @return mixed
     */
    public function HGetAll($key)
    {
        return $this->handler()->HGETALL($key);
    }

    /**
     * NAME: hDel 删除一个或多个哈希表字段
     * @param $key
     * @param $field
     * @return mixed
     */
    public function hDel($key, $field)
    {
        return $this->handler()->hDel($key, $field);
    }

    /**
     * NAME: hExists 查看哈希表 key 中，指定的字段是否存在
     * @param $key
     * @param $hashKey
     */
    public function hExists($key, $hashKey)
    {
        return $this->handler()->hExists($key, $hashKey);
    }

    /**
     * NAME: hLen
     * @param $key
     */
    public function hLen($key)
    {
        return $this->handler()->hLen($key);
    }

    /**
     * NAME: hSet
     * @param $key
     * @param $hashKey
     * @param $value
     */
    public function hSet($key, $hashKey, $value)
    {
        return $this->handler()->hSet($key, $hashKey, $value);
    }

    public function hGet($key, $hashKey)
    {
        return $this->handler()->hGet($key, $hashKey);
    }

    /**
     * NAME: hMset
     * @param $key
     * @param $hashKeys
     */
    public function hMset($key, array $hashKeys)
    {
        return $this->handler()->hMset($key, $hashKeys);
    }

    public function hMGet($key, array $hashKeys)
    {
        return $this->handler()->hMGet($key, $hashKeys);
    }

    public function hIncrBy($key, $hashKey, $value)
    {
        return $this->handler()->hIncrBy($key, $hashKey, $value);
    }

    /**
     * 选择redis的库 默认选择第三个
     */
    public function select($key = 3)
    {
        return $this->handler()->select($key);
    }

    public function hsetNX($key, $hashKey, $value)
    {
        return $this->handler()->hsetNX($key, $hashKey, $value);
    }

    public function hvals($key)
    {
        return $this->handler()->HVALS($key);
    }

    public function del($key)
    {
        return $this->handler()->DEL($key);
    }
}
