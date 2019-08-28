<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/6 9:57
 * Email: 1183@mapgoo.net
 */

namespace app\admin\validate;


use app\admin\model\AdminModel;
use app\admin\model\RoleModel;
use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'userName'    => 'require|checkUserName',
        'userPass'    => 'require',
        'rid'         => 'require',
        'roleName'    => 'require|checkRoleName',
    ];

    protected $message  =   [
        'userName.require'=> '账号名不能为空',
        'userPass'        => '请输入正确的登录密码',
        'rid'             => '请选择管理员角色'
    ];

    protected $scene = [
		'create'  =>  ['userName', 'userPass', 'rid'],
        'update'  =>  ['userName', 'rid'],
        'roleUpdate' => ['roleName'],
    ];

    public function checkUserName($userName , $rule , $data)
    {
        $where['userName'] = $userName;
        if(isset($data['aid'])){
            $where['aid'] = ['neq', $data['aid']];
        }
        $res = (new AdminModel())->where($where)->field('aid')->find();
        if($res){
            return '账号名已存在';
        }
        return true;
    }

    public function checkRoleName($roleName, $rule, $data)
    {
        $where['roleName'] = $roleName;
        if(isset($data['rid'])){
            $where['rid'] = ['neq', $data['rid']];
        }
        $res = (new RoleModel())->where($where)->field('rid')->find();
        if($res){
            return '角色名已存在';
        }
        return true;
    }
}