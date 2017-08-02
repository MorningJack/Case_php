<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/25
 * Time: 下午11:21
 */

namespace app\api\Validate;


use think\Exception;
use think\Request;
use think\Validate;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
//                'code' => 400,
//                'errorCode' => 10002
            ]);
//            $e->msg = $this->error;
//            $e -> errorCode = 10002;
            throw $e;
            /* $error = $this->error;
             throw new Exception($error);*/
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $data = '', $filed = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
//            return $filed.'必须是正整数';
            return false;
        }
    }

    protected function isNotEmpty($value, $rule = '', $data = '', $filed = '')
    {
        if (empty($value)) {
            return false;
        } else {
//            return $filed.'必须是正整数';
            return true;
        }
    }

    protected function isMobile($value, $rule = '', $data = '', $filed = '')
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d(8)$^';
        $result = preg_match($rule,$value);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays) |
            array_key_exists('uid',$arrays)
        ) {
            //不允许包含user_id 或者uid ,防止恶意覆盖user_id外键
            throw new ParameterException([
                    'msg' => '参数重包含非法的参数名user_id或uid'
                ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value){
            $newArray[$key] = $arrays['key'];
        }
        return $newArray;
    }
}