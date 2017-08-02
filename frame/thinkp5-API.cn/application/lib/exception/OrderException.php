<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/6/6
 * Time: 下午11:07
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}