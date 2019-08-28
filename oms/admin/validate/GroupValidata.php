<?php
/**
 * Description of GroupValidata
 *
 * @author guoguo
 */

namespace app\admin\validate;

use think\Validate;
class GroupValidata extends Validate
{
    protected $rule = [
        'permission' => 'require',
    ];

    protected $message  =   [
        'permission' => '参数不能为空',
    ];
    
    protected $scene = [
        'check' =>  ['permission'],
    ];
}
