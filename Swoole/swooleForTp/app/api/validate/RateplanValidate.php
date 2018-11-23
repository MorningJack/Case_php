<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 11:45
 * Email: 1183@mapgoo.net
 */

namespace app\api\validate;


class RateplanValidate extends BaseValidate
{
    /**
     * 检查排队资费计划提交参数是否正确
     * @param array $data
     * @return bool
     */
    public function checkQueue(array $data = []):bool
    {
        if($this->check($data)){
            $validate = [
                'iccid', 'renewalRatePlan'
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

    /**
     * 检查修改卡资费计划提交参数是否正确
     * @param array $data
     * @return bool
     */
    public function checkEdit(array $data = []):bool
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
            return true;
        }
        return false;
    }
}