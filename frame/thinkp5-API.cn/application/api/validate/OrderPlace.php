<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/6/6
 * Time: 下午7:44
 */

namespace app\api\Validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $oProducts = [

    ];

    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [//不是自动验证
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger',
    ];

    protected function checkProducts($values){
        if(!is_array($values)){
            throw new ParameterException([
               'msg' => '商品参数不正确',
            ]);
        }

        if(empty($values)){
            throw new ParameterException([
               'msg' => '商品列表不能为空',
            ]);
        }
        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }

    protected  function checkProduct($value){
        $validate = new BaseValidate($this->singleRule);//手动调用singlerule
        $result =$validate->check($value);
        if(!$result){
            throw new ParameterException([
                'msg' => '商品列表参数错误',
            ]);
        }
    }
}