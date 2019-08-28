<?php
/**
 * 查看管理员操作日志
 * @time 2018-07-25 19:44
 * @author guoguo
 */
namespace app\admin\controller;

use think\Request;
use app\admin\model\LogModel;
class Oplog {
    public function actionLog(Request $request){
        $req = [
            'name' => $request->param('name',''),
            'type' => $request->param('type','','intval'),
            'pageSize'    =>  $request->param('pageSize' , 10 , 'intval'),
            'pageNum'     =>  $request->param('pageNum' , 1 , 'intval'),
        ];
        
        $res = (new LogModel())->oplog($req);
        
        ajax_info(0,'success',$res);
        
    }
}
