<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/12 19:27
 * Email: 1183@mapgoo.net
 */

namespace app\api\validate;


class BaseValidate
{
    protected $error = '';

    /**
     * 验证是否成功
     * @param array $data
     * @return bool
     */
    protected function check(array $data = []):bool
    {
        $validate = [
            'messageId', 'soureType', 'params'
        ];
        foreach ($validate as $value){
            if(empty($data[$value])){
                $this->error = 'invalid ' . $value;
                return false;
            }
        }
        if($data['priority'] < 0 || $data['priority'] > 9){
            $this->error = 'priority in 1 - 9';
            return false;
        }
        return true;
    }

    /**
     * 返回错误信息
     * @return string
     */
    public function getError():string
    {
        return $this->error;
    }
}