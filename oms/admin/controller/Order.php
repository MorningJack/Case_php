<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/2 15:19
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;


use app\admin\model\OrderModel;
use app\admin\validate\OrderValidate;
use think\Request;

class Order
{
    public function orderList(Request $request){
        $req = [
            'orderType'    => $request->param('orderType' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'pageSize'     => $request->param('pageSize' , 10 , 'intval') ,
            'pageNum'      => $request->param('pageNum' , 1 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        $result = (new OrderModel())->orderList($req);
        ajax_info(0 , 'success' , $result);
    }

    public function orderExport(Request $request){
        $req = [
            'orderType'    => $request->param('orderType' , 0 , 'intval') ,
            'dateNumber'   => $request->param('dateNumber' , 0 , 'intval') ,
            'searchKey'    => $request->param('searchKey' , '') ,
            'searchValue'  => $request->param('searchValue' , '') ,
            'startTime'    => $request->param('startTime' , '') ,
            'endTime'      => $request->param('endTime' , '') ,
        ];
        (new OrderModel())->orderExport($req);
    }

    public function orderDel(Request $request){
        $req = [
            'oid'    => $request->param('oid' , '' )
        ];
        $result = (new OrderModel())->orderDel($req);
        if($result){
            ajax_info(0 , 'success');
        }else{
            ajax_info(1, '删除失败');
        }
    }

    public function orderInfo(Request $request){
        $req = [
            'oid'    => $request->param('oid' , 0 , 'intval')
        ];
        $result = (new OrderModel())->orderInfo($req);
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1, '获取失败');
        }
    }

    public function addOrder(Request $request)
    {
        $req = [
            'oid'         => $request->param('oid' , 0 , 'intval'),
            'oiid'        => $request->param('oiid' , 0 , 'intval'),
            'did'         => $request->param('did' , 0 , 'intval'),
            'plateNum'    => $request->param('plateNum', ''),
            'carOwner'    => $request->param('carOwner', ''),
            'shelfCode'   => $request->param('shelfCode', ''),
            'engineCode'  => $request->param('engineCode', ''),
            'brand'       => $request->param('brand', ''),
            'taskTime'    => $request->param('taskTime'),
            'title'       => $request->param('title'),
            'wired'       => $request->param('wired', 0, 'intval'),
            'wireless'    => $request->param('wireless', 0, 'intval'),
            'masters'     => $request->param('masters', ''),
            'reward'      => $request->param('reward', ''),
            'contacts'    => $request->param('contacts', ''),
            'mobile'      => $request->param('mobile', ''),
            'prov'        => $request->param('prov', ''),
            'city'        => $request->param('city', ''),
            'region'      => $request->param('region', ''),
            'address'     => $request->param('address', ''),
            'lat'         => $request->param('lat'),
            'lng'         => $request->param('lng'),
            'remark'      => $request->param('remark', ''),
            'orderState'  => $request->param('orderState', ''),
        ];
        $validate = new OrderValidate();
        $validateType = $req['oid'] ? 'update' : 'add';
        if(!$validate->scene($validateType)->check($req)){
            ajax_info(1 , $validate->getError());
        }
        $result = (new OrderModel())->{$validateType . 'Order'}($req);
        if($result){
            ajax_info(0 , 'success');
        }else{
            ajax_info(1, '添加失败');
        }
    }

    public function orderUpdateInfo(Request $request)
    {
        $req = [
            'oid'    => $request->param('oid' , 0 , 'intval'),
            'oiid'   => $request->param('oiid' , 0 , 'intval'),
            'did'    => $request->param('did' , 0 , 'intval')
        ];
        $result = (new OrderModel())->orderUpdateInfo($req);
        if($result){
            ajax_info(0 , 'success' , $result);
        }else{
            ajax_info(1, '获取失败');
        }
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $info = $file->validate(['size'=>2097152, 'ext'=>['xls', 'xlsx']])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            ajax_info("0","Success", 'uploads/' . $info->getSaveName());
        }else{
            ajax_info(1, $file->getError());
        }
    }

    public function importOrder(Request $request)
    {
        set_time_limit(0);
        $req = [
            'path'    => $request->param('path', ''),
        ];
        $validate = new OrderValidate();
        if(!$validate->scene('path')->check($req)){
            ajax_info(1 , $validate->getError());
        }
        $result = (new OrderModel())->importOrder($validate->path);
        if($result){
            ajax_info(0 , 'success', $result);
        }else{
            ajax_info(1, '添加失败');
        }
    }
}