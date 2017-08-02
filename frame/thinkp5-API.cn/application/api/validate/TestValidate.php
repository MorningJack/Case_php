<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/18
 * Time: 下午11:53
 */

namespace app\api\Validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule = [
      'name' => 'require|max:10'
    ];
}