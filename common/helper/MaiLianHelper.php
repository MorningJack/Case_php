<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/8/22
 * Time: 11:17
 */

namespace app\common\helper;


use app\index\extend\HttpClient;
use think\Config;
use think\Log;

class MaiLianHelper
{
    public function __construct()
    {
        $this->httpModel = new HttpClient();
        $this->key = config('MaiLianHelper.key');
        $this->userid = config('MaiLianHelper.userid');
        $this->url = config('MaiLianHelper.maiLianUrl');
        $this->config = config('MaiLianHelper');
    }

    public $key;//调用密钥
    public $userid;//调用用户id

    public function sign($time)
    {
        return strtoupper(md5($this->userid . $this->key . $time));
    }

    /**
     * @param string $iccid   卡号
     * @return int  0 联通卡, 1 非联通卡
     */
    public function cardType($iccid = '')
    {
        $unicomIdentification = Config::get('unicomIdentification');
        $befor = substr($iccid, 0, 6);
        if(in_array($befor, $unicomIdentification, true)){
            return 0;
        }else{
            return 1;
        }
    }

    /**
     * 移动卡单卡详情
     * @param string $iccid  卡号
     * @param array $optional  选填参数
     * @return mixed
     */
    public function terminalDetailByCmcc($iccid = '', $optional = [])
    {
        $data['userId'] = $this->userid;
        $data['timestamp'] = time();
        $data['sign'] = $this->sign($data['timestamp']);
        $data['optional'] = $optional;
        $data['num_type'] = 'iccid';
        $data['num'] = $iccid;
        $http = new HttpClient();
        $http->setHeader('content-type', 'application/json');
        $http->setReadTimeOut(10);
        $http->setConnTimeOut(10);
        $returnData = $http->Request($this->url . 'open/cmcc/TerminalDetail', 'POST', json_encode($data));
        if($http->status !== 200){
            ajax_info(1,'流量卡查询失败');
        }
        $returnData = json_decode($returnData, true);
        if($returnData && $returnData['error'] !== 0){
            Log::info('MaiLianError - - terminalDetailByCmcc : ' . $returnData['reason']);
            ajax_info(1,$returnData['reason'] ? $returnData['reason'] : '查询麦联宝流量卡失败');
        }
        return $returnData['result'];
    }

    /**
     * NAME: terminalDetail 单卡详情
     * @param $req
     * @return mixed
     */
    public function terminalDetail($iccid = '', $optional = [])
    {
        $data['userId'] = $this->userid;
        $data['timestamp'] = time();
        $data['sign'] = $this->sign($data['timestamp']);
        $data['optional'] = $optional;
        $data['num_type'] = 'iccid';
        $data['num'] = $iccid;
        $http = new HttpClient();
        $http->setHeader('content-type', 'application/json');
        $http->setReadTimeOut(10);
        $http->setConnTimeOut(10);
        $returnData = $http->Request($this->url . 'open/unicom/TerminalDetail', 'POST', json_encode($data));
        if($http->status !== 200){
            ajax_info(1,'流量卡查询失败');
        }
        $returnData = json_decode($returnData, true);
        if($returnData && $returnData['error'] !== 0){
            Log::error('MaiLianError - - TerminalDetai : ' . $returnData['reason']);
            ajax_info(1,$returnData['reason'] ? $returnData['reason'] : '查询麦联宝流量卡失败');
        }
        return $returnData['result'];
    }


    /**
     * 获取单卡续费记录
     */
    public function renewalRecords($iccid, $startTime = '', $endTime = '', $optional = [])
    {
        $data['userId'] = $this->userid;
        $data['timestamp'] = time();
        $data['sign'] = $this->sign($data['timestamp']);
        $data['optional'] = $optional;
        $data['num_type'] = 'iccid';
        $data['start_time'] = $startTime;
        $data['end_time'] = $endTime;
        $data['num'] = $iccid;
        $http = new HttpClient();
        $http->setHeader('content-type', 'application/json');
        $http->setReadTimeOut(10);
        $http->setConnTimeOut(10);
        $returnData = $http->Request($this->url . 'open/unicom/RenewalRecords', 'POST', json_encode($data));
        if($http->status !== 200){
            return false;
        }
        $returnData = json_decode($returnData, true);
        if($returnData && $returnData['error'] !== 0){
            return false;
        }
        return $returnData['result'];
    }

    /**
     * 获取卡可续费列表
     * @param string $iccid  iccid卡
     * @param string $appid  appid
     * @param array $optional
     * @return array
     */
    public function renewalsPackageList($iccid = '', $appid = '', $optional = [])
    {
        $renewalsPackageListUrl = $this->url . 'open/unicom/RenewalsPackageList';
        $data['userId'] = $this->userid;
        $data['timestamp'] = time();
        $data['sign'] = $this->sign($data['timestamp']);
        $data['optional'] = $optional;
        $data['num_type'] = 'iccid';
        $data['num'] = $iccid;
        if($appid){
            $data['appId'] = $appid;
        }
        $http = new HttpClient();
        $http->setHeader('content-type', 'application/json');
        $returnData = $http->Request($renewalsPackageListUrl, 'POST', json_encode($data));
        if($http->status !== 200){
            Log::error('renewalsPackageList error : http status ' . $http->status);
            return [];
        }
        $returnData = json_decode($returnData, true);
        if($returnData && $returnData['error'] !== 0){
            Log::error('renewalsPackageList error: ' . print_r ($returnData, true));
            return [];
        }else{
            return !empty($returnData['result']) ? $returnData['result'] : [];
        }
    }


    public function memberBaseInfo($imei = '', $appKey = '')
    {
        $renewalsPackageListUrl = Config::get('MaiLianHelper.memberBaseInfo');
        $data['imei'] = $imei;
        $http = new HttpClient();
        $http->setHeader('appKey', $appKey);
        $returnData = $http->Request($renewalsPackageListUrl . '?' . http_build_query($data), 'GET');
        if($http->status !== 200){
            Log::info('memberBaseInfo error : http status ' . $http->status);
            return [];
        }
        $returnData = json_decode($returnData, true);
        if($returnData && $returnData['error'] !== 0){
            Log::info('memberBaseInfo error: ' . print_r ($returnData, true));
            return [];
        }else{
            return !empty($returnData['result']) ? $returnData['result'] : [];
        }
    }

    /**
     * 查询卡套餐类型 result ： 0-非麦谷卡,1 基础-基础套餐  2 基础-分离套餐  3 基础-无限套餐 4 运营-基础套餐 5 运营-分离套餐 6 运营-无限套餐
     * @param string $iccid
     * @return array|int
     */
    public function simPackageType($iccid = '')
    {
        $data['userId'] = $this->userid;
        $data['timestamp'] = time();
        $data['sign'] = $this->sign($data['timestamp']);
        $data['optional'] = ['package_type'];
        $data['num_type'] = 'iccid';
        $data['num'] = $iccid;
        $http = new HttpClient();
        $http->setHeader('content-type', 'application/json');
        $http->setReadTimeOut(10);
        $http->setConnTimeOut(10);
        $returnData = $http->Request($this->url . 'open/unicom/TerminalDetail', 'POST', json_encode($data));

        if($http->status !== 200){
            return 0;
        }
        $returnData = json_decode($returnData, true);
        if($returnData && $returnData['error'] !== 0){
            return 0;
        }
        $result = $returnData['result'];
        $package = isset($result['package_type']) ? $result['package_type'] : '';
        switch ($package){
            case '基础-基础套餐':
                $packageType = 1;
                break;
            case '基础-分离套餐':
                $packageType = 2;
                break;
            case '基础-无限套餐':
                $packageType = 3;
                break;
            case '运营-基础套餐':
                $packageType = 4;
                break;
            case '运营-分离套餐':
                $packageType = 5;
                break;
            case '运营-无限套餐':
                $packageType = 6;
                break;
            default:
                $packageType = 0;
                break;
        }
        return $packageType;
    }

    /**
     * @param string $iccid   卡号
     * @param int $package     套餐ID
     * @param int $price      实付价格
     * @param int $originalPrice  原价
     * @param string $orderNum  订单号
     * @param string $couponNum   优惠券号
     * @param string $tradeType   支付方式
     * @param bool $msg   是否返回具体错误原因
     * @return bool|string
     */
    public function renewals($iccid = '', $package = 0, $price = 0, $originalPrice = 0, $orderNum = '', $couponNum = '', $tradeType = '', $msg = false){
        $url = $this->url . 'open/unicom/Renewals';
        $data['userId'] = $this->userid;
        $data['timestamp'] = time();
        $data['sign'] = $this->sign($data['timestamp']);
        $data['packagesn'] = $package;
        $data['price'] = $price;
        $data['original_price'] = $originalPrice;

        if($orderNum)$data['user_ordersn'] = $orderNum;
        if($tradeType)$data['trade_type'] = $tradeType;
        if($couponNum)$data['coupon_num'] = $couponNum;

        $data['num_type'] = 'iccid';
        $data['num'] = $iccid;
        $http = new HttpClient();
        $http->setConnTimeOut(60);
        $http->setReadTimeOut(60);
        $http->setHeader('content-type', 'application/json');
        $response = $http->Request($url, 'POST', json_encode($data));
        if($http->status != 200){
            if($msg){
                return "网络请求失败";
            }else{
                return false;
            }
        }
        $response = json_decode($response,true);
        if($response && $response['error'] == 0){
            return $response['result'];
        }else{
            Log::info("renewals Error : " . print_r($response, true));
            if($msg){
                return isset($response['reason']) ? $response['reason'] : "未知错误";
            }else{
                return false;
            }
        }
    }

    /**
     * NAME: packageList 套餐列表
     * @return mixed
     */
    public function packageList($echo = true)
    {
        $packageListUrl = Config::get('maiLianOmsUrl') . 'api/OMSPackage/GetPackageList';
        $list = $this->httpModel->Request($packageListUrl);
        $list = json_decode($list, true);
        if ($list && isset($list['error']) && $list['error'] == 0) {
            return $list['result'];
        } else {
            if($echo){
                ajax_info(1, '获取套餐失败');
            }else{
                return [];
            }
        }
    }

    public function getHoldList($deviceTypes = '')
    {
        $getHoldListUrl = Config::get('maiLianOmsUrl') . 'api/OMSHold/GetHoldList?deviceTypes='.$deviceTypes;
        $list = $this->httpModel->Request($getHoldListUrl);
        $list = json_decode($list, true);
        if ($list && isset($list['error']) && $list['error'] == 0) {
            return $list['result'];
        } else {
            return [];
        }
    }

    /**
     * NAME: packageInfo 套餐详情
     * @param $id
     * @return mixed
     */
    public function packageInfo($id)
    {
        $get['packageId'] = $id;
        $packageInfoUrl = Config::get('maiLianOmsUrl') . 'api/OMSPackage/GetPackageInfo';
        $info = $this->httpModel->Request($packageInfoUrl . '?' . http_build_query($get));
        if ($this->httpModel->status == 200) {
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return $info['result'];
            } else {
                ajax_info(1, $info['reason']);
            }
        } else {
            ajax_info(1, '获取套餐详情失败');
        }
    }

    public function packageCreate($param = [])
    {
        $url = Config::get('maiLianOmsUrl') . 'api/OMSPackage/SyncPackageInfo';
        $http = new HttpClient();
        $http->setHeader('content-type', 'application/json');
        $info = $http->Request($url, 'POST', json_encode($param));
        if ($this->httpModel->status == 200) {
            $info = json_decode($info, true);
            if ($info && $info['error'] == 0) {
                return !empty($info['result']['packageSn']) ? $info['result']['packageSn'] : 0;
            } else {
                ajax_info(1, '麦联宝套餐添加失败');
            }
        } else {
            ajax_info(1, '获取套餐详情失败');
        }
    }

	/**
     * NAME: getIccidUse 通过iccid获取累计金额和累计续费次数
     * @param $iccidList 123,123,123
     * @return array
     */
    public function getIccidUse($iccidList)
    {
        $url = $this->config['getIccidUse'].'/'. $iccidList;
        $info = $this->httpModel->Request($url);
        if ($this->httpModel->status == 200) {
            $info = json_decode($info, true);
            if ($info && $info['error'] == 0 && $info['result']) {
                $first = reset($info['result']);
                return !empty($first['iccid']) ? $info['result'] : [];
            } else {
                Log::info( '获取麦联宝累计数据失败: '.$iccidList);
                return [];
            }
        } else {
            Log::info( '获取麦联宝累计数据失败: '.$iccidList);
            return [];
        }
    }

    /**
     * NAME: getAddUpList 通过大数据组获取累计开通记录数据
     * $param $iccid 流量卡号
     * @return array
     */
    public function getAddUpList($iccid , $req)
    {

        foreach ($req as $key => $value){
            if(empty($value) && $value !== "0"){
                unset($req[$key]);
            }
        }
        $param = http_build_query($req);
        $url = $this->config['getAddUpList'].'/'.$iccid .'?'.$param;

        $info = $this->httpModel->Request($url);
        if ($this->httpModel->status == 200) {
            $info = json_decode($info, true);
            if ($info && $info['error'] == 0) {
                return $info['result'] ? $info['result'] : [];
            } else {
                Log::info( '获取麦联宝累计记录失败');
                return [];
            }
        } else {
            Log::info( '获取麦联宝累计记录失败');
            return [];
        }
    }

    /**
     * NAME: paymentCat 通过大数据组获取麦联宝支付方式类别
     * @return string
     */
    public function paymentCat($iccid)
    {
        $url = $this->config['paymentCat'].$iccid;
        $info = $this->httpModel->Request($url);
        if ($this->httpModel->status == 200) {
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return $info['result'] ? $info['result'] : '';
            } else {
                ajax_info(1, $info['reason']);
            }
        } else {
            ajax_info(1, '获取支付分类失败');
        }
    }

    public function getSimTagInfo($iccid = '')
    {
        if(!$iccid)return [];
        $get['iccid'] = $iccid;
        $getSimTagUrl = Config::get('maiLianOmsUrl') . 'api/OMSPackage/GetSimTagInfoForOms';
        $info = $this->httpModel->Request($getSimTagUrl . '?' . http_build_query($get));
        if ($this->httpModel->status == 200) {
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return isset($info['result']['tagList']) ? $info['result']['tagList'] : [];
            }
        }
        return [];
    }

    /**
     * NAME: getSimBill 获取历史用量
     * @param string $sim
     * @return array
     */
    public function getSimBill($iccid)
    {
        $data['timestamp'] = time();
        $data['sign'] = $this->sign($data['timestamp']);
        $data['num_type'] = 'iccid';
        $data['num'] = $iccid;
        $data['userId'] = $this->userid;
        $this->httpModel->setHeader('content-type', 'application/json');
        $getSimTagUrl = $this->url . 'open/unicom/HistoryMonthUsage';
        $info = $this->httpModel->Request($getSimTagUrl,'POST',json_encode($data));
        if ($this->httpModel->status == 200) {
            $info = json_decode($info, true);
            if ($info['error'] == 0) {
                return isset($info['result']) ? $info['result'] : [];
            }
        }
        return [];
    }
}