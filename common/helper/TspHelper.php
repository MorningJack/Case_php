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

class TspHelper
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
    public function createTspOrder($req, $order)
    {
        $this->http->setHeader('content-type', 'application/json');
        $time = date('Y-m-d H:i:s', time());
        $url = $this->config['tspUrl'] . '/tsp/adduserservice';
        $requstData = [];
        $i = 0;
        foreach ($req['productList'] as $k => $v) {
            $requstData[$i]['PushUrl'] = $url;
            $requstData[$i]['Body']['userid'] = $req['userid'];
            $requstData[$i]['Body']['imei'] = $req['imei'];
            $requstData[$i]['Body']['iccid'] = $req['iccid'];
            $requstData[$i]['Body']['orderid'] = $order['orderId'];
            $requstData[$i]['Body']['ordersn'] = $order['orderSN'];
            $requstData[$i]['Body']['productid'] = $v['id'];
            $requstData[$i]['Body']['supplierid'] = $v['supplierId'];
            $requstData[$i]['Body']['total_count'] = 100;//临时写死100次
            $requstData[$i]['Body']['order_time'] = $time;
            $requstData[$i]['Body']['effective_time'] = $req['effectiveTime'];//生效时间
            $requstData[$i]['Body']['expire_time'] = $req['expireTime'];//过期时间
            $requstData[$i]['Body']['typeid'] = 1;//临时全部购买救援服务
            $requstData[$i]['Body']['phone'] = $req['phone'];
            $requstData[$i]['Body']['username'] = $req['username'];
            $i++;
        }
        //将服务加入到tsp服务中
        $infoArr = $this->http->ConcurrentRequest($requstData, 'POST');
        if ($this->http->status == 200) {
            if (empty($infoArr)) {
                return false;
            }
            foreach ($infoArr as $key => $info) {
                if ($info['error'] !== 0) {
                    Log::error('createTspOrder 创建tsp可用服务失败：' . $info['reason']);
                    return false;
                }
            }
            return true;
        } else {
            Log::error('createTspOrder 创建tsp可用服务失败,返回码有误：' . $this->http->status);
            return false;
        }
    }

    /**
     * NAME: serviceInfo 获取service详情
     * @param $requestParam
     * @return bool
     */
    public function serviceInfo($requestParam)
    {
        $this->http->setHeader('content-type', 'application/json');
        $url = $this->config['tspUrl'] . '/tsp/serviceInfo?' . http_build_query($requestParam);
        $info = $this->http->Request($url, 'GET');

        if ($this->http->status == 200) {
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return $info['result'];
            } else {
                Log::error('serviceInfo 获取service有误：' . $info['reason']);
                return false;
            }
        } else {
            Log::error('serviceInfo 获取service,返回码有误：' . $this->http->status);
            return false;
        }
    }

    public function startService($requestParam)
    {
        $this->http->setHeader('content-type', 'application/json');

        $url = $this->config['tspUrl'] . '/tsp/startService';
        $info = $this->http->Request($url, 'POST', json_encode($requestParam));

        if ($this->http->status == 200) {
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return $info['result'];
            } else {
                Log::error('startService 发起服务error：' . $info['reason']);
                ajax_info(1, $info['reason']);
                return false;
            }
        } else {
            Log::error('startService 发起服务,返回码有误：' . $this->http->status);
            return false;
        }
    }
}