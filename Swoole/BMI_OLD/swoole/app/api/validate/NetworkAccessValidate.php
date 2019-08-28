<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 14:24
 * Email: 1183@mapgoo.net
 */

namespace app\api\validate;


class NetworkAccessValidate extends BaseValidate
{
    /**
     * 检查获取设备当前的通讯网络配置提交参数是否正确
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

    /**
     * 检查修改设备通信网络配置提交参数是否正确
     * @param array $data
     * @return bool
     */
    public function checkEdit(array $data = []):bool
    {
        if($this->check($data)){
            $validate = [
                'iccid', 'nacId'
            ];
            foreach ($validate as $value){
                if(empty($data['params'][$value])){
                    $this->error = 'invalid ' . $value;
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}