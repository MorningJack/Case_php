<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 17:20
 * Email: 1183@mapgoo.net
 */

namespace app\admin\validate;


use think\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        'userPass'    => 'require',
        'loginName'   => 'require',
        'idCard'      => 'max:19'
    ];

    protected $message  =   [
        'userPass'               => '密码不能为空',
        'userName'               => '登录账号不能为空',
        'idCard'                 => '身份证错误'
    ];

    protected $scene = [
        'login'     =>  ['userPass' , 'userName'],
        'qualification' => ['idCard'],
    ];


    public function checkUserName($userName , $rule , $data){
        if(!empty($data['userType'])){
            if(!isUserName($userName)){
                return '请提交正确的用户名';
            }
            $where['userName'] = $userName;
            $userModel = new UserModel();
            $member = $userModel->getFieldByWhere($where , 'uid');
            if(!empty($member['uid'])){
                return '用户名已经存在';
            }
        }
        return true;
    }

}