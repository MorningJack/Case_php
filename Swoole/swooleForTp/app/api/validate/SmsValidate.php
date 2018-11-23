<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 17:04
 * Email: 1183@mapgoo.net
 */

namespace app\api\validate;


class SmsValidate extends BaseValidate
{
    /**
     * 检查发送短信提交参数是否正确
     * @param array $data
     * @return bool
     */
    public function checkSendSms(array $data = []):bool
    {
        if($this->check($data)){
            $validate = [
                'sentToIccid', 'messageText'
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