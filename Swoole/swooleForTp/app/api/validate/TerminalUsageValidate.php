<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 15:34
 * Email: 1183@mapgoo.net
 */

namespace app\api\validate;


class TerminalUsageValidate extends BaseValidate
{
    /**
     * 检查获取设备当前用量明细是否正确
     * @param array $data
     * @return bool
     */
    public function checkGetDetail(array $data = []):bool
    {
        if($this->check($data)){
            $validate = [
                'iccid', 'cycleStartDate'
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
     * 检查获取设备用量是否正确
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
            return true;
        }
        return false;
    }
}