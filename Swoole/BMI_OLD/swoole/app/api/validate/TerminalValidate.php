<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 10:13
 * Email: 1183@mapgoo.net
 */

namespace app\api\validate;


class TerminalValidate extends BaseValidate
{
    /**
     * 检查提交参数是否正确
     * @param array $data
     * @return bool
     */
    public function checkEdit(array $data = []):bool
    {
        if($this->check($data)){
            $validate = [
                'iccid', 'changeType'
            ];
            foreach ($validate as $value){
                if(empty($data['params'][$value])){
                    $this->error = 'invalid ' . $value;
                    return false;
                }
            }
            if(is_int($data['params']['changeType'])){
                return true;
            }else{
                $this->error = 'changeType not is_int';
            }
        }
        return false;
    }

    /**
     * 检查获取详情信息正确性
     * @param array $data
     * @return bool
     */
    public function checkGet(array $data = []):bool
    {
        if($this->check($data)){
            $validate = [
                'iccids'
            ];
            foreach ($validate as $value){
                if(empty($data['params'][$value])){
                    $this->error = 'invalid ' . $value;
                    return false;
                }
            }
            if(is_array($data['params']['iccids'])){
                return true;
            }else{
                $this->error = 'iccids not is_array';
            }
        }
        return false;
    }

    /**
     * 检查获取基本资费计划和所有排队资费计划信息正确性
     * @param array $data
     * @return bool
     */
    public function checkGetRating(array $data = []):bool
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
            if(is_array($data['params']['iccid'])){
                return true;
            }else{
                $this->error = 'iccid not is_array';
            }
            return true;
        }
        return false;
    }

    /**
     * 检查获取账单详情信息正确性
     * @param array $data
     * @return bool
     */
    public function checkGetAuditTrail(array $data = []):bool
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
            if(is_array($data['params']['iccid'])){
                return true;
            }else{
                $this->error = 'iccid not is_array';
            }
            return true;
        }
        return false;
    }
}