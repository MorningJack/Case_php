<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 13:06
 * Email: 1183@mapgoo.net
 */

namespace app\api\validate;


class SessionValidate extends BaseValidate
{
    /**
     * 检查获取设备会话信息提交参数是否正确
     * @param array $data
     * @return bool
     */
    public function checkGet(array $data = []):bool
    {
        if($this->check($data)){
            $validate = [
                'iccid'
            ];
            foreach ($validate as $value){
                if(empty($data['params'][$value])){
                    $this->error = 'invalid ' . $value;
                    return false;
                }
            }
            if(!is_array($data['params']['iccid'])){
                $this->error = 'iccid is not array';
                return false;
            }
            return true;
        }
        return false;
    }
}