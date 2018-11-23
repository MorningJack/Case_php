<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/26
 * Time: 上午12:12
 */

namespace app\api\Validate;

class IDMustBepostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];
    protected $message = [
        'id' => 'id必须是正整数',
    ];

}