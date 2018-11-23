<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/31
 * Time: 上午11:52
 */

namespace app\api\Validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty',
    ];

    protected $message = [
        'code' => '没有code，获取不到token',
    ];
}