<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/31
 * Time: 上午1:05
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 400;
    public $msg = '指定的商品不存在，请检查参数';
    public $errorCode = '20000';//
}