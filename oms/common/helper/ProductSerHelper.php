<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/8/22
 * Time: 11:17
 */

namespace app\common\helper;


use app\index\extend\HttpClient;
use think\Log;

class ProductSerHelper
{
    public function __construct()
    {
        $this->http = new HttpClient();
        $this->config = config('ProductSerHelper');
    }

    /**
     * NAME: createTspOrder 创建tsp可用服务订单
     * @param $req
     * @param $order
     * @return bool
     */
    public function createTspOrder($req,$order)
    {
        $this->http->setHeader('content-type', 'application/json');
        $time = date('Y-m-d H:i:s',time());
        $url = $this->config['tspUrl'] . '/tsp/adduserservice';
        $requstData = [];
        $i = 0;
        foreach($req['productList'] as $k=>$v){
            $requstData[$i]['PushUrl'] = $url;
            $requstData[$i]['Body']['userid'] = $req['userid'];
            $requstData[$i]['Body']['imei'] = $req['imei'];
            $requstData[$i]['Body']['iccid'] = $req['iccid'];
            $requstData[$i]['Body']['orderid'] = $order['orderId'];
            $requstData[$i]['Body']['ordersn'] = $order['orderSN'];
            $requstData[$i]['Body']['productid'] = $v['id'];
            $requstData[$i]['Body']['supplierid'] = $v['supplierId'];
            $requstData[$i]['Body']['total_count'] = $v['initialValue'];
            $requstData[$i]['Body']['order_time'] = $time;

            $requstData[$i]['Body']['effective_time'] = $req['effectiveTime'];//生效时间
            $requstData[$i]['Body']['expire_time'] =  $v['expireTime'] > 0  ? date('Y-m-d H:i:s',$v['expireTime']) : $req['expireTime'];//过期时间 对时间处理
            $requstData[$i]['Body']['typeid'] = 1;//临时全部购买救援服务
            $requstData[$i]['Body']['phone'] = $req['phone'];
            $requstData[$i]['Body']['username'] = $req['username'];

            $requstData[$i]['Body']['productName'] = $v['productNameExternal'];
            $requstData[$i]['Body']['pid'] = $v['pid'];
            $requstData[$i]['Body']['chargeMode'] = $v['chargeMode'];
            $requstData[$i]['Body']['chargeUnit'] = $v['chargeUnit'];
            $requstData[$i]['Body']['rechargeCode'] = $v['rechargeCode'];
            $requstData[$i]['Body']['objectId'] = $req['objectId'];
            $requstData[$i]['Body']['assetName'] = $v['externalName'];
            $i++;
        }
        Log::log($requstData);
        //将服务加入到tsp服务中
        $infoArr = $this->http->ConcurrentRequest($requstData,'POST');
        if($this->http->status == 200){
            if(empty($infoArr)){
                return false;
            }
            foreach ($infoArr as $key => $info){
                if($info['error'] !== 0){
                    Log::error('createTspOrder 创建tsp可用服务失败：'.$info['reason']);
                    return false;
                }
            }
            return true;
        }else{
            Log::error('createTspOrder 创建tsp可用服务失败,返回码有误：'.$this->http->status);
            return false;
        }
    }

    /**
     * NAME: createVioOfPushOrder 创建违章推送服务
     */
    public function createVioOfPushOrder($requstData)
    {
        $this->http->setHeader('content-type', 'application/json');
        $this->http->setHeader("Authorization" , $this->config['vioOfPush']['appKey']);
        $url = $this->config['vioOfPush']['url'];

        $info = $this->http->Request($url,'POST',$requstData);
        if($this->http->status == 200){
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return $info['result'];
            } else {
                return false;
            }
        }else{
            Log::error('createVioOfPushOrder 创建违章推送服务失败,返回码有误：'.$this->http->status);
            return false;
        }
    }

    /**
     * NAME: escortProList 获取特约类型列表
     * @return bool
     */
    public function escortProList()
    {
        //将服务加入到tsp服务中
        $this->http->setHeader("Authorization", $this->config['Authorization']);
        $url = $this->config['escortProduct'] . '/api/Escort/GetMGEscortProductTypeList';
        $info = $this->http->Request($url, 'GET');
        if($this->http->status == 200){
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return $info['result'];
            } else {
                return false;
            }
        }else{
            Log::error('escortProList 获取特约类型列表失败,返回码有误：'.$this->http->status);
            return false;
        }
    }

    public function GetEscortReportTotal($request)
    {
        $this->http->setHeader('content-type', 'application/json');
        $url =  $this->config['escortProductBaojia'] .'api/Escort/GetEscortReportTotal'.$request;
        $info = $this->http->Request($url,'Get');
        if($this->http->status == 200){
            return $info;
        }else{
            Log::error('GetEscortReportTotal 返回有误：'.$this->http->status);
            return   json_encode(['error' => $this->http->status, 'reason' => '', 'result' => '获取数据错误'], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
        }

    }
    public function GetEscortReportItems($request)
    {
        $this->http->setHeader('content-type', 'application/json');
        $url =  $this->config['escortProductBaojia'] .'api/Escort/GetEscortReportItems'.$request;
        $info = $this->http->Request($url,'Get');
        if($this->http->status == 200){
            return $info;
        }else{
            Log::error('GetEscortReportTotal 返回有误：'.$this->http->status);
            return   json_encode(['error' => $this->http->status, 'reason' => '', 'result' => '获取数据错误'], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
        }

    }
    public function GetEscortReportList($request)
    {
        $this->http->setHeader('content-type', 'application/json');
        $url =  $this->config['escortProductBaojia'] .'api/Escort/GetEscortReportList'.$request;
        $info = $this->http->Request($url,'Get');
        if($this->http->status == 200){
            return $info;
        }else{
            Log::error('GetEscortReportTotal 返回有误：'.$this->http->status);
            return   json_encode(['error' => $this->http->status, 'reason' => '', 'result' => '获取数据错误'], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * NAME: createProductReceive 创建商品资产记录
     * @param array $receives
     */
    public function createProductReceive(array $receives)
    {
        foreach ($receives as $key => $receive){
            $save[$key]['name'] = $receive['name'];
            $save[$key]['rechargeCode'] = $receive['rechargeCode'];
            $save[$key]['chargeMode'] = $receive['chargeMode'];
            $save[$key]['chargeUnit'] = $receive['chargeUnit'];
            $save[$key]['state'] = $receive['state'];
            $save[$key]['initialValue'] = $receive['initialValue'];
            //$save[$key]['releaseTime'] = $receive['releaseTime'] ; 剩余次数
            $save[$key]['validityStartTime'] = $receive['validityStartTime'] ;
            $save[$key]['validityEndTime'] = $receive['validityEndTime'] ;
            $save[$key]['releaseNum'] = $receive['releaseNum'] ;
            $save[$key]['releaseForm'] = $receive['releaseForm'] ;
            $save[$key]['pid'] = $receive['pid'] ;
            $save[$key]['skuId'] = $receive['skuId'] ;
            $save[$key]['productName'] = $receive['productName'];
            $save[$key]['remark'] = $receive['remark'];//发放来源
            $save[$key]['imei'] = $receive['imei'];
            $save[$key]['iccid'] = $receive['iccid'];
            $save[$key]['objectId'] = $receive['objectId'];
            $save[$key]['userName'] = $receive['userName'];
            $save[$key]['userId'] = $receive['userId'];
            $save[$key]['userPhone'] = $receive['userPhone'];
        }

        return (new ProductReceiveModel())->saveAll($save);
    }
}