<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/3 9:08
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;


use app\admin\model\UserWithdrawModel;
use think\Request;

class Withdraw
{
    public function withdrawList(Request $request){
        $req = [
            'state'        => $request->param('state' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'pageSize'     => $request->param('pageSize' , 10 , 'intval') ,
            'pageNum'      => $request->param('pageNum' , 1 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        $result = (new UserWithdrawModel())->withdrawList($req);
        ajax_info(0 , 'success' , $result);
    }

    public function withdrawExport(Request $request){
        $req = [
            'state'        => $request->param('state' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        (new UserWithdrawModel())->withdrawExport($req);
    }
}