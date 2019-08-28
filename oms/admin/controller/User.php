<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 16:21
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;


use app\admin\model\AdminModel;
use app\admin\model\UserModel;
use app\admin\model\RoleModel;
use app\admin\validate\UserValidate;
use app\common\helper\VerifyHelper;
use think\Request;

class User
{
    public function login(Request $request){
        $req = [
            'userName'=> $request->param('userName' , '') ,
            'userPass' => $request->param('userPass' , '') ,
            'code' => $request->param('code' , '') ,
        ];
        if(!VerifyHelper::check($req['code'])){
            ajax_info(1, '验证码有误' );
        }
        $validate = new UserValidate();
        if(!$validate->scene('login')->check($req)){
            ajax_info(1 , $validate->getError());
        }
        $userModel = new AdminModel();
        $res = $userModel->login($req);
        if($res){
            ajax_info(0 , 'success' , $res);
        }else{
            ajax_info(1 , '登录失败:' . $userModel->errMsg);
        }
    }

    /**
     * NAME: logout 账户登出
     */
    public function logout(Request $request)
    {
        $token = $token = $request->header('token');
        (new AdminModel())->logout($token);
        ajax_info(0 , 'success' );
    }

    /**
     * NAME: randomCode 展示验证码
     */
    public function randomCode()
    {
        VerifyHelper::verify();
    }

    public function getUserToken(){
        $req['userName'] = 'admin';
        $userModel = new AdminModel();
        $res = $userModel->login($req , false);
        if($res){
            ajax_info(0 , 'success' , $res);
        }else{
            ajax_info(1 , '登录失败:' . $userModel->errMsg);
        }
    }

    public function userList(Request $request){
        $req = [
            'userType'     => $request->param('userType' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'pageSize'     => $request->param('pageSize' , 10 , 'intval') ,
            'pageNum'      => $request->param('pageNum' , 1 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        $result = (new UserModel())->userList($req);
        ajax_info(0 , 'success' , $result);
    }

    public function userDel(Request $request){
        $req = [
            'uid'    => $request->param('uid' , '')
        ];
        $result = (new UserModel())->userDel($req);
        if($result){
            ajax_info(0 , 'success');
        }else{
            ajax_info(1, '删除失败');
        }
    }

    public function userInfo(Request $request){
        $req = [
            'uid'    => $request->param('uid' , 0 , 'intval')
        ];
        $result = (new UserModel())->userInfo($req);
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1, '查询失败');
        }
    }

    public function userEdit(Request $request){
        $req = [
            'uid'      => $request->param('uid' , 0 , 'intval'),
            'password' => $request->param('password' , ''),
            'remark'   => $request->param('remark' , '')
        ];
        $result = (new UserModel())->userEdit($req);
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1, '修改失败');
        }
    }

    public function userExport(Request $request){
        $req = [
            'userType'     => $request->param('userType' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        (new UserModel())->userExport($req);
    }

    public function masterQualification(Request $request){
        $req = [
            'verification' => $request->param('verification' , 0 , 'intval') ,
            'qualification'=> $request->param('qualification' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'pageSize'     => $request->param('pageSize' , 10 , 'intval') ,
            'pageNum'      => $request->param('pageNum' , 1 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        $result = (new UserModel())->masterQualification($req);
        ajax_info(0 , 'success' , $result);
    }

    public function masterQualificationExport(Request $request){
        $req = [
            'verification' => $request->param('verification' , 0 , 'intval') ,
            'qualification'=> $request->param('qualification' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        (new UserModel())->masterQualificationExport($req);
    }

    public function userQualification(Request $request){
        $req = [
            'verification' => $request->param('verification' , 0 , 'intval') ,
            'qualification'=> $request->param('qualification' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'pageSize'     => $request->param('pageSize' , 10 , 'intval') ,
            'pageNum'      => $request->param('pageNum' , 1 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        $result = (new UserModel())->userQualification($req);
        ajax_info(0 , 'success' , $result);
    }

    public function userQualificationExport(Request $request){
        $req = [
            'verification' => $request->param('verification' , 0 , 'intval') ,
            'qualification'=> $request->param('qualification' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        (new UserModel())->userQualificationExport($req);
    }

    public function qualificationInfo(Request $request){
        $req = [
            'uid'      => $request->param('uid' , 0 , 'intval'),
        ];
        $result = (new UserModel())->qualificationInfo($req);
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1, '获取失败');
        }
    }

    public function qualificationEdit(Request $request){
        $req = [
            'uid'      => $request->param('uid' , 0 , 'intval'),
            'verification' => $request->param('verification' , 0 , 'intval'),
            'qualification' => $request->param('qualification' , 0 , 'intval'),
            'qualificationReason' => $request->param('qualificationReason' , ''),
            'idCard' => $request->param('idCard' , ''),
            'realName' => $request->param('realName' , ''),
            'company' => $request->param('company' , ''),
            'business' => $request->param('business' , ''),
            'remark' => $request->param('remark' , ''),
        ];
        $validate = new UserValidate();
        if(!$validate->scene('qualification')->check($req)){
            ajax_info(1 , $validate->getError());
        }
        $result = (new UserModel())->qualificationEdit($req);
        if($result){
            ajax_info(0 , 'success');
        }else{
            ajax_info(1, '操作失败');
        }
    }

    public function qualificationDel(Request $request){
        $req = [
            'uid'      => $request->param('uid' , ''),
        ];
        $result = (new UserModel())->qualificationDel($req);
        if($result){
            ajax_info(0 , 'success');
        }else{
            ajax_info(1, '操作失败');
        }
    }

    public function getMastersList(Request $request)
    {
        $result = (new UserModel())->mastersList();
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1, '获取失败');
        }
    }

    public function groupList()
    {
        $result = (new RoleModel())->roleSelect();
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1, '获取失败');
        }
    }
}