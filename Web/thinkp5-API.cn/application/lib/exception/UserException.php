<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/31
 * Time: 下午7:59
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}