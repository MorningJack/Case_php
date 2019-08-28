<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 17:20
 * Email: 1183@mapgoo.net
 */

namespace app\admin\validate;


use think\Validate;

class MenuValidate extends Validate
{
    protected $rule = [
        'fid'         => 'require|integer|gt:0',
        'funName'     => 'require',
        'parentFun'   => 'integer|egt:0',
        'status'      => 'in:0,1',
        'sort'        => 'integer|egt:0|elt:100',
        'outLink'        => 'max:200|filter:validate_url',
    ];


    protected $message  =   [
        'parentFun'            => '请输入正确的菜单父节点parentFun',
        'outLink'            => '请输入正确的url外链',
    ];

    protected $scene = [
        'menulist'     =>  ['parentFun' , 'status'],
        'add'          =>  ['funName','parentFun','status','sort','outLink'],
        'edit'         =>  ['fid', 'funName', 'parentFun', 'status', 'sort','outLink'],
        'info'         =>  ['fid'],
    ];


}