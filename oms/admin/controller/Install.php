<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/3 9:37
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;


use app\admin\model\OrderInstallModel;
use think\Request;

class Install
{
    public function installList(Request $request){
        $req = [
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'pageSize'     => $request->param('pageSize' , 10 , 'intval') ,
            'pageNum'      => $request->param('pageNum' , 1 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        $result = (new OrderInstallModel())->installList($req);
        ajax_info(0 , 'success' , $result);
    }

    public function installExport(Request $request){
        $req = [
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval'),
            'searchKey'    => $request->param('searchKey' , ''),
            'searchValue'  => $request->param('searchValue' , ''),
            'oiid'         => $request->param('oiid' , ''),
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        (new OrderInstallModel())->installExport($req);
    }

    public function installInfo(Request $request){
        $req = [
            'oiid'     => $request->param('oiid' , 0 , 'intval') ,
        ];
        $result = (new OrderInstallModel())->installInfo($req);
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1 , '获取失败');
        }
    }

    public function installDel(Request $request){
        $req = [
            'oiid'     => $request->param('oiid' , '') ,
        ];
        $result = (new OrderInstallModel())->installDel($req);
        if($result){
            ajax_info(0 , 'success');
        }else{
            ajax_info(1 , '删除失败');
        }
    }

    public function installTotal(Request $request)
    {
        $req = [
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        $result = (new OrderInstallModel())->installTotal($req);
        ajax_info(0 , 'success' , $result);
    }
}