<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/24
 * Time: 下午11:17
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '指定主题不存在，请检查主题ID';
    public $errorCode = 30000 ;
}