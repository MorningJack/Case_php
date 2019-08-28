<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/8/24
 * Time: 9:15
 */

namespace app\common\helper;


use app\index\extend\HttpClient;
use think\Log;

//中间件调用助手类
class MiddleSysHelper
{
    public function __construct()
    {
        $this->http = new HttpClient();
        $this->MiddleSysConfig = config('MiddleSysHelper');
    }

    private $http;
    private $MiddleSysConfig;//下发指令url


    /**
     * NAME: getObjectIDList 获取设备列表
     * @param array $imeiArr
     */
    public function getObjectIDList(array $imeiArr)
    {
        $url = $this->MiddleSysConfig['getObjInfoByImei'];
        $this->http->setHeader('Authorization', 'mapgoo.net2015');
        $this->http->setHeader("Content-Type", 'application/json');
        $res = $this->http->Request($url, 'POST', json_encode($imeiArr));
        if ($this->http->status !== 200) {
            ajax_info(1, '获取设备详情有误');
        }
        $data = json_decode($res, true);
        if ($data['error'] !== 0) {
            ajax_info(1, $data['reason']);
        }
        return $data['result'];
    }

    /**
     * NAME: getUserInfoByImei 通过imei获取用户信息
     * @param $imei
     * @return bool
     */
    public function getUserInfoByImei($imei)
    {
        $this->http->setHeader('content-type', 'application/json');
        $this->http->setHeader('AppKey', '81B6416D3E05CCCFA0464E75BCC3379E');
        $this->http->setHeader('Authorization', 'mapgoo.net2015');
        $url = $this->MiddleSysConfig['znmlUrl'] . '/api/GetDeviceInsureInfo?imei='.$imei;
        $info = $this->http->Request($url,'Get');

        if($this->http->status == 200){
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return $info['result'];
            } else {
                Log::error('getUserInfoByImei 获取用户信息有误：'.$info['reason']);
                return false;
            }
        }else{
            Log::error('getUserInfoByImei 返回码有误：'.$this->http->status);
            return false;
        }
    }

    public function getOrderInfo($userId, $orderNum)
    {
        $this->http->setHeader('content-type', 'application/json');
        $this->http->setHeader('Authorization', 'mapgoo.net2015');
        $url = $this->MiddleSysConfig['baojiaUrl'] . '/api/mgescort/carowner/GetOrderInfo?user_id=%d&order_sn=%s';
        $response = $this->http->Request(sprintf($url, $userId, $orderNum));
        if($this->http->status == 200){
            $response = json_decode($response, true);
            if ($response['error'] == 0) {
                return $response['result'];
            } else {
                Log::error('getOrderInfo 获取订单信息有误：'.$response['reason']);
                return false;
            }
        }else{
            Log::error('getOrderInfo 返回码有误：'.$this->http->status);
            return false;
        }
    }


    public function callBack($url, $param = [])
    {
        $this->http->setHeader('content-type', 'application/json');
        $this->http->setHeader('Authorization', 'mapgoo.net2015');
        $response = $this->http->Request($url, 'POST', json_encode($param));
        if($this->http->status == 200){
            $response = json_decode($response, true);
            if ($response['error'] == 0) {
                return true;
            } else {
                Log::error('callBack 回调失败：'.$response['reason']);
                return false;
            }
        }else{
            Log::error('callBack 回调失败请求码有误：'.$this->http->status);
            return false;
        }
    }
}