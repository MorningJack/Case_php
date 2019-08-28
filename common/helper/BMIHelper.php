<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/8/24
 * Time: 9:15
 */

namespace app\common\helper;


use app\index\extend\HttpClient;

class BMIHelper
{
    public function __construct()
    {
        $this->bmiUrl = config('BMIHelper');
    }

    protected $onlineUrl = '/extraapi/Track/getObjectCurrentTrack';
    protected $setServiceUrl = '/extraapi/Object/setObjOptionParam';
    protected $getObjectByIMEIUrl = '/extraapi/Object/getObjectByImei';
    protected $setSocolParamsUrl = '/extraapi/Object/setSocolParams';
    protected $getSocolParamsUrl = '/extraapi/Object/getSocolParams';
    protected $getSocolExpireCmdUrl = '/extraapi/Point/expireCmdReport';
    protected $saveCmdStateUrl = '/extraapi/Point/saveCommandStatusByIDS';
    protected $disableOpenSocolUrl = '/extraapi/Object/disableOpenSocol';
    protected $enableOpenSocolUrl = '/extraapi/Object/enableOpenSocol';
    protected $isOpenSocolUrl = '/extraapi/Object/isOpenSocol';
    protected $getSocolConfUrl = '/extraapi/Object/getSocolConf';
    protected $getSocolConfByIdUrl = '/extraapi/Object/getSocolConfById';
    private $bmiUrl;//下发指令url

    public function cmdSend($imei, array $content, $other = [],$source = '')
    {
        if($source == 'BD'){
            $data = $content;
        }else{
            $data = ['imei' => $imei, 'content' => 'Transparent,' . millisecond() . ',' . base64_encode(json_encode($content))];
        }        
        $data += $other;
        $http = new HttpClient();
        $res = $http->Request($this->bmiUrl['cmdSendUrl'], 'POST', json_encode($data));

        if ($http->status == 200) {
            return $res;
        } else {
            trace('cmdSendlog:' . date('Y-m-d H:i:s'), $res);
            ajax_info(1, '推送失败');
        }
    }

    /**
     * NAME: deviceInfo 获取单个设备信息
     * @param $objectid
     * @return mixed
     */
    public function deviceInfo($objectid)
    {
        $httpModel = new HttpClient();
        $singleDeviceInfoUrl = $this->bmiUrl['singleDeviceInfoUrl'];
        $param = ['objID' => $objectid];
        $deviceInfo = $httpModel->Request($singleDeviceInfoUrl, 'POST', json_encode($param));
        if ($httpModel->status !== 200) {
            ajax_info(1, '获取设备信息错误');
        }
        $deviceInfo = json_decode($deviceInfo, true);
        if ($deviceInfo['error'] !== 0) {
            ajax_info('1', $deviceInfo['reason']);
        }
        //特殊处理 如果设备经纬度为空，则使用基站定位
        $deviceInfo = $deviceInfo['result'];
        $deviceInfo['Lat'] = empty($deviceInfo['Lat']) ? $deviceInfo['BSLat'] :  $deviceInfo['Lat'];
        $deviceInfo['Lon'] = empty($deviceInfo['Lon']) ? $deviceInfo['BSLon'] :  $deviceInfo['Lon'];
        return $deviceInfo;
    }

    /**
     * NAME: addressName 根据经纬度获取地名
     * @param $lat
     * @param $lon
     * @return array|mixed|null|string|string[]
     */
    public function addressName($lat, $lon)
    {
        $httpModel = new HttpClient();
        $addressUrl = $this->bmiUrl['addressUrl'] . '/api/v1/GeocoderV3?pos=' . $lon . ',' . $lat;
        $addressInfo = $httpModel->Request($addressUrl);
        $address = $addressInfo;
        $address = explode(',', $address);
        $address = reset($address);
        $address = preg_replace('/\[[0-9]\]/', '', $address);
        return $address;
    }

    /**
     * NAME: objList 获取渠道下的objID
     * @param $param
     * @return mixed
     */
    public function objList($param)
    {
        $httpModel = new HttpClient();
        $objListUrl = $this->bmiUrl['objListUrl'];

        $objectList = $httpModel->Request($objListUrl, 'POST', json_encode($param));
        if ($httpModel->status !== 200) {
            ajax_info(1, '获取设备列表有误');
        }
        $objectList = json_decode($objectList, true);
        if ($objectList['error'] !== 0) {
            ajax_info(1, $objectList['reason']);
        }
        return $objectList['result']['objIDList'];
    }

    /**
     * NAME: deviceList 批量获取设备详情
     * @param $objIDs
     * @return mixed
     */
    public function deviceList($objIDs)
    {
        $httpModel = new HttpClient();
        $objDetailListUrl = $this->bmiUrl['objDetailListUrl'];
        $objDetailObj = $httpModel->Request($objDetailListUrl, 'POST', json_encode(['objIDs' => $objIDs]));
        if ($httpModel->status !== 200) {
            ajax_info(1, '获取设备详情有误');
        }
        $objDetailObj = json_decode($objDetailObj, true);
        if ($objDetailObj['error'] !== 0) {
            ajax_info(1, $objDetailObj['reason']);
        }
        return $objDetailObj['result'];
    }

    /**
     * 获取objectid通过imei
     */
    public function getObjectID($imei){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['objectUrlByImei'].'?'.'imei='.$imei, 'GET');
        if ($httpModel->status !== 200) {
            ajax_info(1, '获取设备详情有误');
        }
        $data = json_decode($res,true);
        if ($data['error'] !== 0) {
            ajax_info(1, '终端号有误');
        }
        return $data['result'];
    }
    
    /**
     * 通过百度设备号获取内部设备号
     */
    public function getObjIDByBDDeviceNo($source,$deviceNo){
        $httpModel = new HttpClient();
        $httpModel->setConnTimeOut(30);
        $httpModel->setReadTimeOut(30);
        $res = $httpModel->Request($this->bmiUrl['getObjIdByBDObjId'].'?'.'deviceNo='.$deviceNo.'&source='.$source, 'GET');
        if ($httpModel->status !== 200) {
            ajax_info(1, '获取设备有误');
        }
        $data = json_decode($res,true);
        if ($data['error'] !== 0) {
            ajax_info(1, '终端号有误');
        }
        return $data['result'];
    }
    
    /**
     * 通过设备号获取百度设备号
     */
    public function getDeviceNoByIMEI($source,$imei){
        $httpModel = new HttpClient();
        $httpModel->setConnTimeOut(30);
        $httpModel->setReadTimeOut(30);
        $res = $httpModel->Request($this->bmiUrl['getBaiduDeviceNo'].'?'.'imei='.$imei.'&source='.$source, 'GET');
        if ($httpModel->status !== 200) {
            ajax_info(1, '获取设备有误');
        }
        $data = json_decode($res,true);
        if ($data['error'] !== 0) {
            ajax_info(1, '终端号有误');
        }
        return $data['result'];
    }

        /**
     * 获取历史轨迹
     */
    public function getGpsTime($param,$bat = '') {
        $httpModel = new HttpClient();
        $httpModel->setConnTimeOut(30);
        $httpModel->setReadTimeOut(30);
        $res = $httpModel->Request($this->bmiUrl['getHistoryTracks'].'?'.http_build_query($param), 'GET');
        if ($httpModel->status !== 200) {
            ajax_info(1, '请求失败');
        }
        $data = json_decode($res,true);
        if($bat == 'BD'){
            return $data;
        }else{
            if ($data['error'] !== 0) {
                ajax_info(1, '请求失败');
            }
            return $data['result'];
        }
        
    }
    
     /**
     * 暂停图片回传
     */
    public function setImgUpload($param) {
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['setImgUpload'].'?'.http_build_query($param), 'GET');
        if ($httpModel->status !== 200) {
            ajax_info(1, '请求失败');
        }
        $data = json_decode($res,true);
        if ($data['error'] !== 0) {
            ajax_info(1, '请求失败');
        }
        return $data['result'];
    }
    
     /**
     * 暂停轨迹回传
     */
    public function setTreceUpload($param) {
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['setTracksUpload'].'?'.http_build_query($param), 'GET');
        if ($httpModel->status !== 200) {
            ajax_info(1, '请求失败');
        }
        $data = json_decode($res,true);
        if ($data['error'] !== 0) {
            ajax_info(1, '请求失败');
        }
        return $data['result'];
    }
    
    /**
     * 设备是否在线
     */
    public function isOnline($param){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->onlineUrl, 'POST',json_encode($param));        
        return $res;
    }
    
    /**
     * 将鹰眼 service_id 推送给HCC
     */
    public function setObjOption($data){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->setServiceUrl, 'POST',json_encode($data));
        return $res;
    }
    
    /**
     * 将鹰眼 service_id 和 ak 推送给HCC
     */
    public function setSocolParams($data){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->setSocolParamsUrl, 'POST',json_encode($data));
        return $res;
    }

    /**
     * 获取设备socol设置
     */
    public function getSocolParams($imei){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->getSocolParamsUrl.'?imei='.$imei, 'GET');
        return $res;
    }

    /**
     * 通过imei获取objectID
     */
    public function getObjectByIMEI($imei){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->getObjectByIMEIUrl.'?imei='.$imei, 'GET');
        $data = json_decode($res,true);
        if (!isset($data['error']) || $data['error'] !== 0) {
            ajax_info(1, '请求失败');
        }
        return $data['result'];
    }
    
    //获取socol过期指令
    public function getSocolExpireCmd($source,$limit){
        $httpModel = new HttpClient();
        $data['source'] = [$source];
        $data['limit'] = $limit;
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->getSocolExpireCmdUrl, 'POST',json_encode($data));
        $data = json_decode($res,true);
        if (!isset($data['error']) || $data['error'] !== 0) {
            ajax_info(1, '请求失败');
        }
        return $data['result'];
    }
    //更新指令状态
    public function saveCmdState($DownIDs){
        $httpModel = new HttpClient();
        $data['downids'] = $DownIDs;
        $data['sendflag'] = -1;
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->saveCmdStateUrl, 'POST',json_encode($data));
        $data = json_decode($res,true);
        if (!isset($data['error']) || $data['error'] !== 0) {
            ajax_info(1, '请求失败');
        }
        return $data['result'];
    }
    /**
     * 设置设备禁用socol
     */
    public function disableOpenSocol($data){
        $httpModel = new HttpClient();
        $httpModel->setHeader('content-type', 'application/json');
        $httpModel->setConnTimeOut(30);
        $httpModel->setReadTimeOut(30);
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->disableOpenSocolUrl, 'POST',$data);
        $resInfo = json_decode($res,true);
        if (!isset($resInfo['error']) || $resInfo['error'] !== 0) {
            ajax_info(1, '请求失败');
        }
        return $resInfo['result'];
    }
    
    /**
     * 设置设备支持socol
     */
    public function enableOpenSocol($data){
        $httpModel = new HttpClient();
        $httpModel->setHeader('content-type', 'application/json');
        $httpModel->setConnTimeOut(30);
        $httpModel->setReadTimeOut(30);
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->enableOpenSocolUrl, 'POST',$data);
        $resInfo = json_decode($res,true);
        if (!isset($resInfo['error']) || $resInfo['error'] !== 0) {
            ajax_info(1, '请求失败');
        }
        return $resInfo['result'];
    }
    
    /**
     * 检测设备是否支持socol
     */
    public function isOpenSocol($data){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->isOpenSocolUrl, 'POST',$data);
        $resInfo = json_decode($res,true);
        if (!isset($resInfo['error']) || $resInfo['error'] !== 0) {
            return false;
        }
        return $resInfo['result'];
    }
    
    /**
     * 获取设备socol设置通过imei
     */
    public function getSocolConf($imei){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->getSocolConfUrl.'?imei='.$imei, 'GET');
        $resInfo = json_decode($res,true);
        if (!isset($resInfo['error']) || $resInfo['error'] !== 0) {
            return false;
        }
        return $resInfo['result'];
    }
    
    /**
     * 获取设备socol设置通过objId
     */
    public function getSocolConfById($objId){
        $httpModel = new HttpClient();
        $res = $httpModel->Request($this->bmiUrl['ip'].$this->getSocolConfUrl.'?objeId='.$objId, 'GET');
        $resInfo = json_decode($res,true);
        if (!isset($resInfo['error']) || $resInfo['error'] !== 0) {
            return false;
        }
        return $resInfo['result'];
    }
}