<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/25
 * Time: 下午11:21
 */

namespace app\api\Validate;



class AddressNew extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty',
    ];
}