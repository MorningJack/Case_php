<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/31
 * Time: 下午7:59
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}