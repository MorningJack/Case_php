<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/6 9:03
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;


use app\admin\model\AdminModel;
use app\admin\model\RoleFunModel;
use app\admin\model\RoleModel;
use app\admin\validate\AdminValidate;
use app\admin\validate\RoleUpdateValidate;
use think\Request;

class Admin
{
    public function admin(Request $request)
    {
        $req = [
            'pageSize'    =>  $request->param('pageSize' , 10 , 'intval'),
            'pageNum'     =>  $request->param('pageNum' , 1 , 'intval')
        ];
        $response = (new AdminModel())->admin($req);
        ajax_info(0, 'success', $response);
    }

    public function adminInfo(Request $request)
    {
        $req = [
            'aid'    =>  $request->param('aid', 0, 'intval')
        ];
        $response = (new AdminModel())->adminInfo($req);
        if($response){
            ajax_info(0, 'success', $response);
        }else{
            ajax_info(1, '查询失败');
        }
    }

    public function adminDelete(Request $request)
    {
        $req = [
            'aid'    =>  $request->param('aid')
        ];
        $response = (new AdminModel())->adminDelete($req);
        if($response){
            ajax_info(0, 'success');
        }else{
            ajax_info(1, '删除失败');
        }
    }

    public function adminInsert(Request $request)
    {
        $req = [
            'userName'    =>  $request->param('userName', ''),
            'userPass'    =>  $request->param('userPass', ''),
            'nickName'    =>  $request->param('nickName',''),
            'remark'      =>  $request->param('remark',''),
            'rid'         =>  $request->param('rid', '')
        ];
        $validate = new AdminValidate();
        if(!$validate->scene('create')->check($req)){
            ajax_info(1, $validate->getError());
        }
        $response = (new AdminModel())->adminUpdate($req);
        if($response){
            ajax_info(0, 'success');
        }else{
            ajax_info(1, '新增失败');
        }
    }

    public function adminUpdate(Request $request)
    {
        $req = [
            'userName'    =>  $request->param('userName', ''),
            'userPass'    =>  $request->param('userPass', ''),
            'nickName'    =>  $request->param('nickName',''),
            'remark'      =>  $request->param('remark',''),
            'rid'         =>  $request->param('rid', ''),
            'aid'         =>  $request->param('aid', 0, 'intval')
        ];
        $validate = new AdminValidate();
        if(!$validate->scene('update')->check($req)){
            ajax_info(1, $validate->getError());
        }
        $response = (new AdminModel())->adminUpdate($req);
        if($response){
            ajax_info(0, 'success');
        }else{
            ajax_info(1, '修改失败');
        }
    }

    public function role(Request $request)
    {
        $req = [
            'pageSize'    =>  $request->param('pageSize' ,10 , 'intval'),
            'pageNum'     =>  $request->param('pageNum' ,1 , 'intval')
        ];
        $response = (new RoleModel())->role($req);
        ajax_info(0, 'success', $response);
    }

    public function roleInfo(Request $request)
    {
        $req = [
            'rid'    =>  $request->param('rid', 0, 'intval')
        ];
        $response = (new RoleModel())->roleInfo($req);
        if($response){
            ajax_info(0, 'success', $response);
        }else{
            ajax_info(1, '查询失败');
        }
    }

    public function roleDelete(Request $request)
    {
        $req = [
            'rid'    =>  $request->param('rid')
        ];
        $response = (new RoleModel())->roleDelete($req);
        if($response){
            ajax_info(0, 'success');
        }else{
            ajax_info(1, '删除失败');
        }
    }

    public function roleInsert(Request $request)
    {
        $req = [
            'roleName'    =>  $request->param('roleName', ''),
            'remark'      =>  $request->param('remark', ''),
            'fid'         =>  $request->param('fid',''),
            'index'       =>  $request->param('index',''),
            'indexName'   =>  $request->param('indexName',''),
        ];
        $validate = new AdminValidate();
        if(!$validate->scene('roleUpdate')->check($req)){
            ajax_info(1, $validate->getError());
        }
        $response = (new RoleModel())->roleUpdate($req);
        if($response){
            ajax_info(0, 'success');
        }else{
            ajax_info(1, '添加失败');
        }
    }

    public function roleUpdate(Request $request)
    {
        $req = [
            'roleName'    =>  $request->param('roleName', ''),
            'remark'      =>  $request->param('remark', ''),
            'rid'         =>  $request->param('rid', 0, 'intval'),
            'fid'         =>  $request->param('fid',''),
            'index'       =>  $request->param('index',''),
            'indexName'   =>  $request->param('indexName',''),
        ];
        $validate = new AdminValidate();
        if(!$validate->scene('roleUpdate')->check($req)){
            ajax_info(1, $validate->getError());
        }
        $response = (new RoleModel())->roleUpdate($req);
        if($response){
            ajax_info(0, 'success');
        }else{
            ajax_info(1, '修改失败');
        }
    }

    public function roleFun(Request $request)
    {
        $req = [
            'rid'    =>  $request->param('rid', 0, 'intval')
        ];
        $response = (new RoleFunModel())->roleFun($req);
        ajax_info(0, 'success', $response);
    }

    public function roleFunUpdate(Request $request)
    {
        $req = [
            'rid'    =>  $request->param('rid', 0, 'intval'),
            'fid'    =>  $request->param('fid'),
        ];
        $response = (new RoleFunModel())->roleFunUpdate($req);
        if($response){
            ajax_info(0, 'success');
        }else{
            ajax_info(1, '修改失败');
        }
    }
}