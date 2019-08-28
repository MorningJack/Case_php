<?php
/**
 * Description of Group
 *
 * @author guoguo
 */

namespace app\admin\controller;
use app\admin\validate\GroupValidata;
use app\admin\model\AdminModel;
use app\admin\behavior\Check;
use think\Request;
class Group {
    public function editCommon(Request $request){
        $aid = Check::$aid;
        $req = [
            'aid'      => $aid,
            'permission' => $request->param('permission','')
        ];
        
        $validate = new GroupValidata();
        if(!$validate->scene('check')->check($req)){
            ajax_info(1 , $validate->getError());
        }
        
        $response = (new AdminModel())->editCommon($req);
        if($response['status'] == 0){
            ajax_info(0 , 'SUCCESS',$response);
        }else{
            ajax_info(1 , 'ERROR',$response);
        }
        
    }
}
