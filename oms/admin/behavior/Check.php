<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 16:26
 * Email: 1183@mapgoo.net
 */

namespace app\admin\behavior;


use app\admin\model\AdminModel;
use app\admin\model\FunModel;
use app\admin\model\LogModel;
use think\Request;

class Check
{
    public static $aid = 0;
    public static $name = '';
    public function run(){
        $request = Request::instance();
        $filter = [
                        'login',
                        'userExport', 'withdrawExport',
                        'orderExport', 'installExport','netContrastOutExcel','netIncreaseOutExcel',
                        'masterQualificationExport', 'userQualificationExport','netCountOutExcel',
                        'getUserToken', 'uploadFile', 'appNameList',
                        'holdTree', 'mdtType', 'netHold', 'netMdtType',
                        'supplierAll', 'rights', 'shopGroup', 'shopAll', 'subscribe','sumUserClick',
                        'randomCode','groupList','getQiniuToken','outVersion',
                        'incomeReportOutExcel','incomeReportBySourceOut','cashReportOut','cashReportBySourceOut','appFlowListOutExecl','appFlowOutExcel','statisticsForExcel',
                        'tagExcelExport','adminInfo','adminUpdate','outOrderExcel','CouponOutExcel','deviceListOutExcel','socolCmdOutExcel','socolListOutExcel','customLabelList', 'activityRecordExport','socolHoldListOutExecl','giveLogListExport','sucReleaseExport'
                    ];

        $authFilter = ['basicIndexCount','sysIncreaseData'];
        $action = $request->action();


        if(!in_array($action , $filter)){

            //随手拍接口鉴权
            $suishoupaitimestamp = $request->header('timestamp');
            $suishoupaiauth = $request->header('auth');
            if($suishoupaitimestamp) {
                $key='4H5F24ZAHU8MTFI6U66T2E8UTDHC8MI9';
                $userid='131415929';
                $sign= md5( $userid.$key.$suishoupaitimestamp);
                if(strtoupper($sign) == strtoupper($suishoupaiauth)){
                    return true;
                }
            }

            $token = $request->header('token');
            if(!$token){
                ajax_info(401 , '登录凭据无效');
            }

            $res = checkTokenExpire($token);
            if(!$res){
                ajax_info(401 , '登录过期');
            }

            $adminModel = new AdminModel();
            $admin = $adminModel->getFieldByWhere(['token' => $token] , 'aid,userName,nickName');
            if(empty($admin)){
                ajax_info(401 , '登录凭据无效');
            }
            self::$aid = $admin->getData('aid');
            $nickName = $admin->getData('nickName');
            if($nickName){
                self::$name = $admin->getData('nickName');
            } else {
                self::$name = $admin->getData('userName');
            }
            //判断权限
            $menu = $request->controller() . '/' . $action;
            if($action == 'permission' || $action == 'userPermission'){//对用户菜单接口做放行
                return true;
            }
            $auth = $adminModel->userPermission(self::$aid,false, $menu);
            if(!in_array($action , $authFilter)){
                if(empty($auth)){
                    ajax_info(403 , '没有权限');
                }
            }            
            $user   = $adminModel->adminInfo(['aid' => self::$aid]);//用户信息
            $this->operationLog($menu,$user);//添加操作日志
        }
        return true;
    }

    /**
     * 添加操作日志
     * $menu funAction 造作方法
     * $user 用户信息
     */
    public  function operationLog($menu,$user)
    {
        //通过funAction 找找出s_fun表对应的事件描述
        $funModel  = new FunModel();
        $fun_info  = $funModel->funInfo($menu);

        if($fun_info){
            $data  = [];
            $data['ip']   = getClientIp();
            $data['aid']  = $user['aid'];
            $data['name'] = $user['userName'];
            $data['module_name']  = $fun_info['funName'] ;
            $data['api_name']  = $fun_info['api_name'] ;
            $data['remark']       = $fun_info['describe']; //暂时用funName替代

            $logModel = new LogModel();
            $logModel->operationLogAdd($data);
        }
    }
}