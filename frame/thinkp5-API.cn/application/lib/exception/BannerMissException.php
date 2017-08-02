<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/24
 * Time: 下午11:17
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Banner不存在';
    public $errorCode = 40000;
}