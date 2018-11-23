<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/25
 * Time: 下午11:28
 */

namespace app\lib\exception;


use think\Exception;
use Throwable;

class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = '10000';//通用参数

    public function __construct($param = [])
    {
        if(!is_array($param)){
            return ;
//            throw new Exception('参数必须是数组');
        }
        if(array_key_exists('code',$param)){
            $this->code = $param['code'];
        }
        if(array_key_exists('msg',$param)){
            $this->msg = $param['msg'];
        }
        if(array_key_exists('errorCode',$param)){
             $this->errorCode = $param['errorCode'];
        }
        parent::__construct();
    }
}