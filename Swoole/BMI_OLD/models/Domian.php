<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/5/19
 * Time: 11:33
 * Email: 1183@mapgoo.net
 */
require_once 'Ice.php';
require_once 'Ice/BuiltinSequences.php';
include ICE_LIB_PATH . 'CacheProxy.php';
include ICE_LIB_PATH . 'RealDataProxy.php';
include ICE_LIB_PATH . 'RARS.php';
include ICE_LIB_PATH . 'OSS.php';
include ICE_LIB_PATH . 'MGSSV.php';
include ICE_LIB_PATH . 'MFS.php';
include ICE_LIB_PATH . 'DAP.php';
include ICE_LIB_PATH . 'CmdPack.php';
include ICE_LIB_PATH . 'AppAgent.php';
include ICE_LIB_PATH . 'ASS.php';
include ICE_LIB_PATH . 'TraceObject.php';
class DomianModel
{
	private static $TRACEhandle;
	private static $ASShandle;
    private static $CAPhandle;
    private static $RDPhandle;
    private static $MFShandle;
    private static $OSShandle;
    private static $DAPhandle;
    private static $MRShandle;
    private static $SSVhandle;
    private static $MFSNAS;
    private static $MFSIDC;
    private static $RARShandle;
    private static $IAShandle = [];
    private static $init_data;
    private static $Region = ['times' => 0 , 'datas' => []];
    private static $RegionCacheTime = 60 * 60 * 24 * 30;
    public function __construct($Config)
    {
        $IceGrid = $Config['IceGrid'];
        self::$init_data = new Ice_InitializationData;
        self::$init_data->properties = Ice_createProperties();
        self::$init_data->properties->setProperty('Ice.MessageSizeMax', 0);
        self::$init_data->properties->setProperty('Ice.Default.Locator', $IceGrid);
        $ic = Ice_initialize(self::$init_data);
        try {
            $Ice_Session = $Config['CAP']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$CAPhandle = CacheProxy_CacheSessionPrxHelper::checkedCast($obj);
            if (!self::$CAPhandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: CAP handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: CAP connect error :".print_r ($ex,true);
            echo "\n";
        }
        try {
            $Ice_Session = $Config['RDP']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$RDPhandle = RealDataProxy_RealDataSessionPrxHelper::checkedCast($obj);
            if (!self::$RDPhandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: RDP handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: RDP connect error :".print_r ($ex,true);
            echo "\n";
        }

        try {
            $Ice_Session = $Config['OSS']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$OSShandle = OSS_OSSSessionPrxHelper::checkedCast($obj);
            if (!self::$OSShandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: OSS handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: OSS connect error :".print_r ($ex,true);
            echo "\n";
        }

        try {
            $Ice_Session = $Config['MFS']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$MFShandle = MFS_MFSSessionPrxHelper::checkedCast($obj);
            if (!self::$MFShandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MFS handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MFS connect error :".print_r ($ex,true);
            echo "\n";
        }

        try {
            $Ice_Session = $Config['DAP']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$DAPhandle = DAPProxy_DAPSessionPrxHelper::checkedCast($obj);
            if (!self::$DAPhandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: DAP handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: DAP connect error :".print_r ($ex,true);
            echo "\n";
        }

        try {
            $Ice_Session = $Config['MRS']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$MRShandle = CmdPack_CmdPackSessionPrxHelper::checkedCast($obj);
            if (!self::$MRShandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MRS handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MRS connect error :".print_r ($ex,true);
            echo "\n";
        }
        try {
            $Ice_Session = $Config['SSV']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$SSVhandle = MGSSV_SSVProxySessionPrxHelper::checkedCast($obj);
            if (!self::$SSVhandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: SSV handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: SSV connect error :".print_r ($ex,true);
            echo "\n";
        }

        try {
            $Ice_Session = $Config['RARS']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$RARShandle = RARS_RARSSessionPrxHelper::checkedCast($obj);
            if (!self::$RARShandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: RARS handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: RARS connect error :".print_r ($ex,true);
            echo "\n";
        }
		
		//ASS配置
        try {
            $Ice_Session = $Config['ASS']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$ASShandle = ASS_ASSsessionPrxHelper::checkedCast($obj);
            if (!self::$ASShandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: ASS handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: ASS connect error :".print_r ($ex,true);
            echo "\n";
        }

		//TRACE配置
        try {
            $Ice_Session = $Config['TRACE']['Session'];
            $obj = $ic->stringToProxy($Ice_Session);
            self::$TRACEhandle = Trace_TraceSessionPrxHelper::checkedCast($obj);
            if (!self::$TRACEhandle) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: TRACE handle is NULL:";
                echo "\n";
            }
        } catch (Ice_LocalException $ex) {
            echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: TRACE connect error :".print_r ($ex,true);
            echo "\n";
        }


        if(!SWOOLE_DEBUG){
            try {
                $Ice_Session = $Config['MFSNAS']['Session'];
                $obj = $ic->stringToProxy($Ice_Session);
                self::$MFSNAS = MFS_MFSSessionPrxHelper::checkedCast($obj);
                if (!self::$MFSNAS) {
                    echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MFSNAS handle is NULL:";
                    echo "\n";
                }
            } catch (Ice_LocalException $ex) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MFSNAS connect error :".print_r ($ex,true);
                echo "\n";
            }
            try {
                $Ice_Session = $Config['MFSIDC']['Session'];
                $obj = $ic->stringToProxy($Ice_Session);
                self::$MFSIDC = MFS_MFSSessionPrxHelper::checkedCast($obj);
                if (!self::$MFSIDC) {
                    echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MFSIDC handle is NULL:";
                    echo "\n";
                }
            } catch (Ice_LocalException $ex) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: MFSIDC connect error :".print_r ($ex,true);
                echo "\n";
            }
        }
    }
    public function getIAShandle($ip , $port){
        if(empty(self::$IAShandle[$ip . ':' . $port])){
            try {
                $Ice_Session = "AgentSession:tcp -p ". $port ." -h " . $ip;
                $Ice_MessageSizeMax = 0;
                self::$init_data->properties->setProperty('Ice.MessageSizeMax', $Ice_MessageSizeMax);
                $ic = Ice_initialize(self::$init_data);
                $obj = $ic->stringToProxy($Ice_Session);
                self::$IAShandle[$ip . ':' . $port] = AppAgent_AgentSessionPrxHelper::checkedCast($obj);
                if (!self::$IAShandle[$ip . ':' . $port]) {
                    echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: IAS handle is NULL:";
                    echo "\n";
                }
            } catch (Ice_LocalException $ex) {
                echo "[".date("Y-m-d H:i:s")."] debug.DEBUG: IAS connect error :".print_r ($ex,true);
                echo "\n";
                return false;
            }
        }
        return self::$IAShandle[$ip . ':' . $port];
    }
    public function sendIASCmd($IAShandle , $cmd){
        return $IAShandle->pushCmd($cmd);
    }

    public function getDevStatusDec($param,$getHoldAlarmList,$alarmType = -1){
        $Dec['Lists'] = $Dec['statusTypeId'] = array();
        $Dec['Dec'] = "";
        $data = $this->getAlarmAndStatus($param);
        if(!empty($data)){
            foreach($data as $v){
                foreach($v->status as $key=>$val){
                    if ($val > 0) {
                        $number = decbin($val);
                        $len = strlen($number);
                        $number = strrev($number);
                        for ($i = 0; $i < $len; $i++) {
                            $flag = $number{$i} & 1;
                            if ($flag) {
                                $RecID = 1000 + $key * 10 + $i;
                                switch($getHoldAlarmList){
                                    case 2:
                                        $Dec['statusTypeId'][] = $RecID;
                                        break;
                                    case 3:
                                        $AlarmTypeID = $RecID;
                                        if($AlarmTypeID && ($alarmType == -1 || $AlarmTypeID == $alarmType)){
                                            $Dec['Lists'][$v->objId][] = $AlarmTypeID;
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        }
        unset($data);
        return $Dec;
    }
    //报警统计数据动态获取
    public function getStatsByAlarmTypeGroup($objArr){
        $alarmCount = $this->getDevStatusDec($objArr,2);
        $countAr = $datas = array();
        if(!empty($alarmCount['statusTypeId'])){
            $countArr = array_count_values($alarmCount['statusTypeId']);
            $i = 0;
            foreach($countArr as $k=>$v){
                if($k && $k!=1092) {
                    $datas[$i]['alarmTypeID'] = $k;
                    $datas[$i]['alarmCount'] = isset($v) ? $v : 0;
                    $i++;
                }
            }
        }
        return $datas;
    }
    public function getCountBydistrictName($param){
        if($param['districtType'] == 1){
            $name = "cityName";
            $code = "cityCode";
            $datas = $this->getStatisticsByCity($param['holdID'],$param['districtName']);
        }else if($param['districtType'] == 2){
            $name = "regionName";
            $code = "regionCode";
            $datas = $this->getStatisticsByRegion($param['holdID'],$param['districtName']);
            $param['districtName'] = $param['cityName'];
        }else{
            $name = "provinceName";
            $code = "provinceCode";
            $datas = $this->getStatisticsByProvince($param['holdID']);
        }
        if($datas['status']->errorcode != 0)return array();
        $lists = $datas['data'];
        $k = 0;
        $districList = $reutrnData = array();
        foreach($lists as $row){
            $districList[$k][$code] = $this->getRegionIDByName($param['districtName'] , $row->districtName , $param['districtType']);
            $districList[$k][$name] = $row->districtName;
            $districList[$k]['onlineCount'] = !empty($row->statistics->online)?$row->statistics->online:0;
            $districList[$k]['offlineCount'] = !empty($row->statistics->offline)?$row->statistics->offline:0;
            $districList[$k]['alarmCount'] = !empty($row->statistics->alarm)?$row->statistics->alarm:0;
            $districList[$k]['invalidCount'] = !empty($row->statistics->invalid)?$row->statistics->invalid:0;
            $num = $districList[$k]['onlineCount'] + $districList[$k]['offlineCount'] + $districList[$k]['alarmCount'] + $districList[$k]['invalidCount'];
            if($num > 0){
                $reutrnData[] = $districList[$k];
            }
            $k++;
        }
        //按在线状态排序
        $sort = array(
            'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field'     => 'onlineCount',       //排序字段
        );
        $arrSort = array();
        foreach($reutrnData as $uniqid => $row){
            foreach($row as $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $reutrnData);
        }
        return $reutrnData;
    }

    public function addTaskInfo($param){
        $params[] = new CacheProxy_TaskInfo(-1 , CacheProxy_TaskType::TASK_RUN_ONCE , $param['delay'] , $param['scheduledTime'] , $param['taskInfo']);
        return self::$CAPhandle->addTaskInfo($params);
    }

    public function getAlarmAndStatus($param){
        $data = array();
        $check = self::$CAPhandle->getAlarmAndStatus($param,$data);
        return $data;
    }
    public function getTracks($param){
        $data = array();
        $check  = self::$CAPhandle->getTracks($param,$data);
        return array('status'=>$check,'data'=>$data);
    }
    public function getTravel($param){
        $data = array();
        $check = self::$CAPhandle->getTravel($param,$data);
        return $check===0?$data:array();
    }
    public function getObjectRouter($objectID){
        $data = array();
        $check = self::$CAPhandle->getObjectRouter($objectID,$data);
        return array('status'=>$check,'data'=>$data);
    }
    public function getObjsByHoldId($param){
        $total= 0;
        $data = array();
        $pageParam = new OSS_Pagesort($param['pageSize'],$param['pageNum']);
        $status = self::$OSShandle->getObjsByHoldId($param['holdID'],$param['statisticsType'],$pageParam,$total,$data);
        return array('status'=>$status,'data'=>$data,'total'=>$total);
    }
    public function getStatisticsByHoldId($param){
        $data = array();
        $check  = self::$OSShandle->getStatisticsByHoldId($param,$data);
        return array('status'=>$check,'data'=>$data);
    }
	
	public function getActiveTravel($param){
        $data = array();
        $check = self::$CAPhandle->getActiveTravel($param,$data);
        return array('status'=>$check,'data'=>$data);
    }

    public function getObjsBydistrictName($param){
        if($param['districtType'] == 1){
            return $this->getObjsByCity($param);
        }else if($param['districtType'] == 2){
            return $this->getObjsByRegion($param);
        }else{
            return $this->getObjsByProvince($param);
        }
        return array();
    }

    public function getObjsByProvince($param){
        $total= 0;
        $data = array();
        $pageParam = new OSS_Pagesort($param['pageSize'],$param['pageNum']);
        $status = self::$OSShandle->getObjsByProvince($param['holdID'],$param['districtName'],$param['statisticsType'],$pageParam,$total,$data);
        return array('status'=>$status,'data'=>$data,'total'=>$total);
    }
    public function getObjsByCity($param){
        $total= 0;
        $data = array();
        $pageParam = new OSS_Pagesort($param['pageSize'],$param['pageNum']);
        $param['districtName'] = explode('-' , $param['districtName']);
        $status = self::$OSShandle->getObjsByCity($param['holdID'] , $param['districtName'][0] , $param['districtName'][1] , $param['statisticsType'] , $pageParam , $total , $data);
        return array('status'=>$status,'data'=>$data,'total'=>$total);
    }
    public function getObjsByRegion($param){
        $total= 0;
        $data = array();
        $pageParam = new OSS_Pagesort($param['pageSize'],$param['pageNum']);
        $param['districtName'] = explode('-' , $param['districtName']);
        $status = self::$OSShandle->getObjsByRegion($param['holdID'] , $param['districtName'][0] , $param['districtName'][1] , $param['districtName'][2] , $param['statisticsType'] , $pageParam , $total , $data);
        return array('status'=>$status,'data'=>$data,'total'=>$total);
    }
    //MRS
    public function packs($cmdInfo){
        $data = array();
        $info = new CmdPack_CmdInfo($cmdInfo['objId'] , $cmdInfo['imei'] , $cmdInfo['factory'] , $cmdInfo['brand'] , $cmdInfo['protocol'] , $cmdInfo['content']);
        $check = self::$MRShandle->pack($info,$data);
        return array('status'=>$check,'data'=>$data);
    }
    //RARS
    public function gerRegionByPoint($param)
    {
        $point = new RARS_GeoPoint(intval($param['lon'] * 1000000), intval($param['lat'] * 1000000));
        $data = array();
        $check = self::$RARShandle->getRegionInfo($point, $data);
        return array('status'=>$check,'data'=>$data);
    }
    //RDP

    /**
     * @param $param
     */
    public function getRealDatas($param){
        $datas = $data = array();
        $check  = self::$RDPhandle->getRealDatasV2($param,$data);
        if($check === 0){
            foreach($data as $k=>$object){
                //$info = array();
                //self::$HCChandle->getObjectById($object->objId , $info);
                $datas[$k]['ObjectID'] = $object->objId;
                $datas[$k]['IsOBD'] = !empty($object->IsOBD) ? $object->IsOBD : ""; //字段无法获取
                $datas[$k]['ObjectName'] = !empty($object->ObjectName) ? $object->ObjectName : ""; //字段无法获取
                $datas[$k]['theDayMileage'] = $object->gpsDataEx->gpsData->mileage > $object->theDayInitMileage ? ($object->gpsDataEx->gpsData->mileage - $object->theDayInitMileage) / 1000.0 : 0;
                $travel = $this->getTravel($object->objId);
                $co = Api_Desc::$comma;
                $datas[$k]['travelMileage'] = !empty($travel->travelMileage) ? round($travel->travelMileage / 1000, 3) : 0;
                $datas[$k]['TravelOil'] = !empty($travel->travelOil) ? round($travel->travelOil / 1000, 3) : 0;
                $datas[$k]['CurrentMileage'] = !empty($travel->travelMileage) ? round($travel->travelMileage / 1000, 3) : 0;
                $datas[$k]['AlarmDesc'] = empty($object->gpsDataEx->gpsData->alarmFlag) ? "" : $object->gpsDataEx->gpsData->alarmDesc;
                $datas[$k]['IsStop'] = empty($travel)?1:($travel->isCompleted?1:0);
                $datas[$k]['TransType'] = !empty($object->isOnline) ? (int)$object->isOnline: 0;//是否在线
                $datas[$k]['IsLink'] = !empty($object->isLink) ? (int)$object->isLink: 0;//是否断开链接
                $datas[$k]['IsSleep'] = !empty($object->isSleep) ? (int)$object->isSleep: 0;//是否休眠
                $datas[$k]['BeidouSignal'] =!empty($object->gpsDataEx->gpsData->beidousatelliteNum) && $object->gpsDataEx->gpsData->beidousatelliteNum!=255 ? $object->gpsDataEx->gpsData->beidousatelliteNum : 0;
                $datas[$k]['AlarmFlag'] = empty($object->gpsDataEx->gpsData->alarmFlag) ? 0 : 1;
                $datas[$k]['AlarmType'] = !empty($object->gpsDataEx->gpsData->alarmType) ? $object->gpsDataEx->gpsData->alarmType : '';
                $datas[$k]['provinceName'] = !empty($object->gpsDataEx->adminRegion->province) ? $object->gpsDataEx->adminRegion->province : 0;
                $datas[$k]['Lat'] = !empty($object->gpsDataEx->gpsData->point->lat) ? number_format($object->gpsDataEx->gpsData->point->lat / 1000000.0, 6) : '';
                $datas[$k]['Lon'] = !empty($object->gpsDataEx->gpsData->point->lng) ? number_format($object->gpsDataEx->gpsData->point->lng / 1000000.0, 6) : '';
                $object->gpsDataEx->gpsData->battery = $datas[$k]['Voltage'] = !empty($object->gpsDataEx->gpsData->battery) && $object->gpsDataEx->gpsData->battery!=255 ? floor($object->gpsDataEx->gpsData->battery / 10): 0;
                $datas[$k]['Speed'] = !empty($object->gpsDataEx->gpsData->speed) ? $object->gpsDataEx->gpsData->speed : 0;
                $datas[$k]['RcvTime'] = $object->gpsDataEx->gpsData->rcvTime > 0 ? date('Y-m-d H:i:s', $object->gpsDataEx->gpsData->rcvTime) : '';
                $datas[$k]['Mileage'] = !empty($object->gpsDataEx->gpsData->mileage) ? round($object->gpsDataEx->gpsData->mileage / 1000, 3) : 0;
                $datas[$k]['Direct'] = !empty($object->gpsDataEx->gpsData->direction) ? $object->gpsDataEx->gpsData->direction : 0;
                $datas[$k]['GSMSignal'] = !empty($object->gpsDataEx->gpsData->gsmStrength) && $object->gpsDataEx->gpsData->gsmStrength!=255? $object->gpsDataEx->gpsData->gsmStrength : 0;
                $datas[$k]['GPSSignal'] = !empty($object->gpsDataEx->gpsData->satelliteNum) && $object->gpsDataEx->gpsData->satelliteNum!=255 ? $object->gpsDataEx->gpsData->satelliteNum : 0;
                if(empty($object->statusDesc)){
                    $StatusDes = Api_Desc::getStatusDesc($object->gpsDataEx->gpsData,1);
                    $datas[$k]['StatusDes'] = $datas[$k]['AlarmDesc']?trim($datas[$k]['AlarmDesc'].$co.$StatusDes,$co):$StatusDes;
                }else{
                    $datas[$k]['StatusDes'] = htmlentities($object->statusDesc);
                }
                $datas[$k]['BSLat'] = !empty($object->bsLat) ? number_format($object->bsLat / 1000000.0, 6) : 0;
                $datas[$k]['BSLon'] = !empty($object->bsLon) ? number_format($object->bsLon / 1000000.0, 6) : 0;
                $datas[$k]['WifiLat'] = !empty($object->wifiLat) ? number_format($object->wifiLat / 1000000.0, 6) : 0;
                $datas[$k]['WifiLon'] = !empty($object->wifiLon) ? number_format($object->wifiLon / 1000000.0, 6) : 0;
                $datas[$k]['WifiTime'] = !empty($object->wifiTime) ? date('Y-m-d H:i:s', $object->wifiTime) : '';
                $datas[$k]['BSTime'] = !empty($object->bsTime) ? date('Y-m-d H:i:s', $object->bsTime) : '';
                $datas[$k]['GPSTime'] = !empty($object->gpsDataEx->gpsData->gpsTime) ? date('Y-m-d H:i:s', $object->gpsDataEx->gpsData->gpsTime) : '';
                $datas[$k]['GPSFlag'] = 0;
				$datas[$k]['OilNum'] = !empty($object->oilNum) ? $object->oilNum : 0;
                /*$timeArr = array(
                    'gpsTime' => !empty($object->gpsDataEx->gpsData->gpsTime) ? $object->gpsDataEx->gpsData->gpsTime : 0,
                    'mixedTime' => !empty($object->mixedTime) ? $object->mixedTime : 0,
                    'wifiTime' => !empty($object->wifiTime) ? $object->wifiTime : 0,
                    'bsTime' => !empty($object->bsTime) ? $object->bsTime : 0,
                    'notAccuracyGPSTime' => !empty($object->notAccuracyGPSTime) ? $object->notAccuracyGPSTime : 0,
                );*/
                $gpsAccuracyType = $object->gpsDataEx->gpsData->gpsAccuracyType;// = $this->getGpsAccuracyType($timeArr , $info);
                if (isset($gpsAccuracyType) && $gpsAccuracyType == 2) {
                    $datas[$k]['GPSFlag'] = 318;
                } else if (isset($gpsAccuracyType) && ($gpsAccuracyType == 0 || $gpsAccuracyType == 1)) {
                    $datas[$k]['GPSFlag'] = $gpsAccuracyType == 1 ? 308 : 307;
                    if($datas[$k]['GPSFlag'] == 308){
                        if(empty($object->notAccuracyGPSLat) || empty($object->notAccuracyGPSLon) || empty($object->notAccuracyGPSTime)){
                            $datas[$k]['GPSFlag'] = 307;
                            echo 'GPS ERROR:' . $object->objId . '\n';
                        }else{
                            $datas[$k]['Lat'] = number_format($object->notAccuracyGPSLat / 1000000.0, 6);
                            $datas[$k]['Lon'] = number_format($object->notAccuracyGPSLon / 1000000.0, 6);
                            $datas[$k]['GPSTime'] = date('Y-m-d H:i:s', $object->notAccuracyGPSTime);
                        }
                    }
                } else if(isset($gpsAccuracyType) && $gpsAccuracyType == 3){
                    $datas[$k]['GPSFlag'] = 347;
                }
            }
        }
        unset($data);
        return $datas;
    }
    public function getRedisDatas($param){
        $data = array();
        $check = self::$RDPhandle->getRealDatas($param,$data);
        return array('status'=>$check,'data'=>$data);
    }
    //mfs
    public function RecordsTest($objectId, $beginTime, $endTime, $speed_limit, $Exact, $limit)
    {
        ini_set('memory_limit', '256M');
        $rs = $this->getRecords($objectId, $beginTime, $endTime);
        $data = array();
        if ($rs['status'] === 0) {
            $alldata = $rs['data'];
            $pre_mileage = 0;
            //$pre_gpsTime = 0;
            $total_mileage = 0;
            $total = 0;

            foreach ($alldata as $k=>$v) {

                $v = (array)$v;
                if ($v['lon'] == 0 || $v['lat'] == 0)continue;
                if ($v['speed'] <= $speed_limit)continue;
                if ($Exact > 0 && !$this->filterAccuracyType($v['gpsAccuracyType'], $Exact))continue;
                if ($v['gpsTime'] < $beginTime || $v['gpsTime'] > $endTime)continue;
                if ($pre_mileage == 0)$pre_mileage = $v['mileage'];
                //if ($pre_gpsTime == 0)$pre_gpsTime = $v['gpsTime'];
                $item = array();
                $item['id'] = $objectId;
                $item['lon'] = number_format($v['lon'] / 1000000.0, 6);
                $item['lat'] = number_format($v['lat'] / 1000000.0, 6);
                $transform = Api_CoordinateTransform::WGS2BD(array('Lng' => $item['lon'], 'Lat' => $item['lat']));
                $item['rlon'] = number_format($transform['Lng'], 6);
                $item['rlat'] = number_format($transform['Lat'], 6);
                $item['voltage'] = !empty($v['battery']) && $v['battery']!=255 ? $v['battery'] : 0;
                $item['gpssignal'] = !empty($v['satelliteNum']) && $v['satelliteNum']!=255 ? $v['satelliteNum'] : 0;
                $item['speed'] = $v['speed'];
                $item['direct'] = $v['direct'];
                $item['totalmile'] = $v['mileage'] > 0 ? $v['mileage'] : 0;
                $cur_mileage = $v['mileage'];
                //$cur_gpsTime = $v['gpsTime'];
                $mileage_span = (($cur_mileage < $pre_mileage) ? 0 : $cur_mileage - $pre_mileage);
                $total_mileage += $mileage_span;
                $pre_mileage = $cur_mileage;
                //$pre_gpsTime = $cur_gpsTime;
                $item['mile'] = round($total_mileage / 1000.0, 2);
                $item['gpsTime'] = date('Y-m-d H:i:s', $v['gpsTime']);
                $item['rcvTime'] = date('Y-m-d H:i:s', $v['rcvTime']);
                $item['status'] = Api_Desc::getStatusDesc($v);
                $item['posmode'] = Api_Desc::$GPSAccuracyTypeArray[$v['gpsAccuracyType']];
                $item['gpsFlag'] = $this->getGPSAccuracyTypeCode($v['lon'], $v['lat'], $v['gpsAccuracyType']);
                array_push($data, $item);
                unset($alldata[$k]);
                ++$total;
                if ($limit > 0 && $total >= $limit) {
                    break;
                }
            }
        }
        return $data;
    }

   //mfs
    public function Records($objectId, $beginTime, $endTime, $speed_limit, $Exact, $limit)
    {
        ini_set('memory_limit', '256M');
        $timeScheme = $this->getTimeScheme($beginTime , $endTime);
        krsort($timeScheme);
        $data = array();
        foreach ($timeScheme as $schme => $times){
            if($schme == 1){
                $func = 'getNASRecords';
            }else if ($schme == 2){
                $func = 'getIDCRecords';
            }else{
                $func = 'getRecords';
            }
            $rs = $this->{$func}($objectId , $times['start'] , $times['end']);
            if ($rs['status'] === 0) {
                $alldata = $rs['data'];
                $pre_mileage = 0;
                //$pre_gpsTime = 0;
                $total_mileage = 0;
                $total = 0;
                foreach ($alldata as $k=>$v) {

                    $v = (array)$v;
                    if ($v['lon'] == 0 || $v['lat'] == 0)continue;
                    if ($v['speed'] <= $speed_limit)continue;
                    if ($Exact > 0 && !$this->filterAccuracyType($v['gpsAccuracyType'], $Exact))continue;
                    if ($v['gpsTime'] < $beginTime || $v['gpsTime'] > $endTime)continue;
                    if ($pre_mileage == 0)$pre_mileage = $v['mileage'];
                    //if ($pre_gpsTime == 0)$pre_gpsTime = $v['gpsTime'];
                    $item = array();
                    $item['id'] = $objectId;
                    $item['lon'] = number_format($v['lon'] / 1000000.0, 6);
                    $item['lat'] = number_format($v['lat'] / 1000000.0, 6);
                    $transform = Api_CoordinateTransform::WGS2BD(array('Lng' => $item['lon'], 'Lat' => $item['lat']));
                    $item['rlon'] = number_format($transform['Lng'], 6);
                    $item['rlat'] = number_format($transform['Lat'], 6);
                    $item['voltage'] = !empty($v['battery']) && $v['battery']!=255 ? $v['battery'] : 0;
                    $item['gpssignal'] = !empty($v['satelliteNum']) && $v['satelliteNum']!=255 ? $v['satelliteNum'] : 0;
                    $item['speed'] = $v['speed'];
                    $item['direct'] = $v['direct'];
                    $item['totalmile'] = $v['mileage'] > 0 ? $v['mileage'] : 0;
                    $cur_mileage = $v['mileage'];
                    //$cur_gpsTime = $v['gpsTime'];
                    $mileage_span = (($cur_mileage < $pre_mileage) ? 0 : $cur_mileage - $pre_mileage);
                    $total_mileage += $mileage_span;
                    $pre_mileage = $cur_mileage;
                    //$pre_gpsTime = $cur_gpsTime;
                    $item['mile'] = round($total_mileage / 1000.0, 2);
                    $item['gpsTime'] = date('Y-m-d H:i:s', $v['gpsTime']);
                    $item['rcvTime'] = date('Y-m-d H:i:s', $v['rcvTime']);
                    $item['status'] = Api_Desc::getStatusDesc($v);
                    $item['posmode'] = Api_Desc::$GPSAccuracyTypeArray[$v['gpsAccuracyType']];
                    $item['gpsFlag'] = $this->getGPSAccuracyTypeCode($v['lon'], $v['lat'], $v['gpsAccuracyType']);
                    array_push($data, $item);
                    unset($alldata[$k]);
                    ++$total;
                    if ($limit > 0 && $total >= $limit) {
                        break;
                    }
                }
            }
        }
        return $data;
    }

    public function getRecords($objectId, $beginTime, $endTime){
        $data = array();
        $check = self::$MFShandle->getRecords($objectId,$beginTime,$endTime,$data);
        return array('status'=>$check,'data'=>$data);
    }

    public function addRecords($objectId, $rcvTime, $gpsTime, $lon, $lat, $speed, $direct ){
        $mdtStatus = [0,0,0,0,0,0,0,0,0,0,0,0];
        $dpsData   = new MFS_GPSData($gpsTime, $rcvTime, $lon, $lat, 0, $speed, $direct, 0, 0, 0, 0, 0, 0, $mdtStatus);
        $gpsRecord = new MFS_GPSRecord($objectId,$dpsData);
        $check = self::$MFShandle->addRecords([$gpsRecord]);
        return array('status'=>$check);
    }

    //NAS主机
    public function getNASRecords($objectId, $beginTime, $endTime){
        $data = array();
        $check = self::$MFSNAS->getRecords($objectId,$beginTime,$endTime,$data);
        return array('status'=>$check,'data'=>$data);
    }

    //IDC机房
    public function getIDCRecords($objectId, $beginTime, $endTime){
        $data = array();
        $check = self::$MFSIDC->getRecords($objectId,$beginTime,$endTime,$data);
        return array('status'=>$check,'data'=>$data);
    }

    public function getStatisticsByProvince($holdID){
        $data = array();
        $check = self::$OSShandle->getStatisticsByProvince($holdID,$data);
        return array('status'=>$check,'data'=>$data);
    }
    public function getStatisticsByCity($holdID,$districtName){
        $data = array();
        $check = self::$OSShandle->getStatisticsByCity($holdID,$districtName,$data);
        return array('status'=>$check,'data'=>$data);
    }
    public function getStatisticsByRegion($holdID,$districtName){
        $data = array();
        $districtName = explode("-" , $districtName);
        $check = self::$OSShandle->getStatisticsByRegion($holdID , $districtName[0] , $districtName[1] ,$data);
        return array('status'=>$check,'data'=>$data);
    }
    //DAP
    public function GetObjectinfoByImei($param){
        $data = array();
        $check  = self::$DAPhandle->GetObjectinfoByImei($param,$data);
        return array('status'=>$check,'data'=>$data);
    }
    public function GetObjectinfoByImeiSSV($param){
        $data = array();
        $check  = self::$DAPhandle->GetObjectinfoByImeiSSV($param,$data);
        return array('status'=>$check,'data'=>$data);
    }
    public function GetObjectinfoById($objectID){
        $data = array();
        $check  = self::$DAPhandle->GetObjectinfoByIdSSV($objectID,$data);
        return array('status'=>$check,'data'=>$data);
    }
    public function SaveCommands($param){
        $message = new DAPProxy_DownInfo($param['DownID'] , $param['ObjectID'] , $param['sendContent'] , $param['CMDTypeID'] , $param['SubmitTime'] , $param['sendUserID'] , $param['sim'] , $param['remark'] , $param['sendFlag'] , $param['sendsource'] , $param['TransType'] , $param['DownInfoType'] , (string)$param['seq']);
        return self::$DAPhandle->SaveCommands($message);
    }
    public function setRegionDistricts(){
        $data = array();
        self::$DAPhandle->GetRegionDistricts($data);
        self::$Region['times'] = time();
        foreach($data as $val){
            self::$Region['datas'][$val->recid] = array(
                'province' => $val->province,
                'city' => $val->city,
                'region' => $val->region,
            );
        }
    }
    public function getRegionByID($ID){
        if(!$ID)return array();
        if((time() - self::$Region['times']) > self::$RegionCacheTime){
            $this->setRegionDistricts();
        }
        if(empty(self::$Region['datas'][$ID])){
            $data = array();
            self::$DAPhandle->GetRegionDistrictById($ID , $data);
            if(!empty($data)){
                self::$Region['datas'][$ID] = array(
                    'province' => $data->province,
                    'city' => $data->city,
                    'region' => $data->region,
                );
            }else{
                self::$Region['datas'][$ID] = array(
                    'province' => "",
                    'city' => "",
                    'region' => "",
                );
            }
        }
        return self::$Region['datas'][$ID];
    }
    public function getRegionIDByName($city = "" , $region = "" , $type = 0){
        if((time() - self::$Region['times']) > self::$RegionCacheTime){
            $this->setRegionDistricts();
        }
        $city = $city ? $city : $region;
        $ID = 0;
        if($type == 2){
            $f = 'city';
            $s = 'region';
        }else{
            $f = 'province';
            $s = 'city';
        }
        foreach(self::$Region['datas'] as $key => $val){
            $c[0] = $val[$f];
            $c[1] = $city;
            $c[2] = $val[$s];
            $c[3] = $region;
            if(strlen($val[$f]) < strlen($city)){
                $c[0] = $city;
                $c[1] = $val[$f];
            }
            if(strlen($val[$s]) < strlen($region)){
                $c[2] = $region;
                $c[3] = $val[$s];
            }
            if(strpos($c[0] , $c[1]) !== false && strpos($c[2] , $c[3]) !== false){
                $ID = $key;
                break;
            }
        }
        return $ID;
    }
    //SSV
    public function TakeCmd($param , $type = ''){
        $check = -1;
        $info = array();
        $seq = 0;
        if($type == 1){
            $message = new MGSSV_TakePhotoReq($param['deviceId'] , $param['width'] , $param['height'] , $param['count'], $param['interval'] , $param['cameratype']);
            $check = self::$SSVhandle->takePhoto($message , $info , $seq);
        }else if($type == 2){
            $message = new MGSSV_TakeVideoReq($param['deviceId'] , $param['width'] , $param['height'] , $param['fps'], $param['duration'] , $param['cameratype']);
            $check = self::$SSVhandle->takeVideo($message , $info , $seq);
        }
        return $req = array(
            'status' => $check,
            'info' => $info,
            'seq' => $seq
        );
    }
    public function getCameraInfo($deviceId){
        $data = array();
        $CameraInfoReq = new MGSSV_CameraInfoReq($deviceId);
        $check = self::$SSVhandle->getCameraInfo($CameraInfoReq , $data);
        return array('status'=>$check,'data'=>$data);
    }

    public function getVideoLiveInfo($deviceId)
    {
        $data = array();
        $DeviceCameraLiveReq = new MGSSV_DeviceCameraLiveReq($deviceId, [MGSSV_CAMERA_TYPE::CAMERA_TYPE_FROUNT], [640, 360], -1);
        $check = self::$SSVhandle->getVideoLiveInfo($DeviceCameraLiveReq , $data);
        return array('status'=>$check,'data'=>$data);
    }
    //ISA
    public function pushCmd($IAS , $param){
        $message = new AppAgent_AppCmd($param['SequenceNo'] , $param['Imei'] , $param['Content'] , $param['Digest']);
        return $IAS->pushCmd($message);
    }
    private function filterAccuracyType($gpsAccuracyType, $Exact)
    {
        $result = true;
        switch ($Exact) {
            case 1:
                if ($gpsAccuracyType == 1) {
                    $result = false;
                }
                break;
            case 2:
                if ($gpsAccuracyType == 2 || $gpsAccuracyType == 3) {
                    $result = false;
                }
                break;
            case 3:
                if ($gpsAccuracyType == 1 || $gpsAccuracyType == 2 || $gpsAccuracyType == 3) {
                    $result = false;
                }
                break;
            default:
                $result = true;
                break;
        }

        return $result;
    }
    private function getGPSAccuracyTypeCode($lon, $lat, $type)
    {
        if ($lon > 0) {
            if ($lat > 0) {
                return self::$gpsAccuracyTypeCode["eastNorth"][$type];
            } else# if ($lat < 0)
            {
                return self::$gpsAccuracyTypeCode["eastSouth"][$type];
            }
        } else if ($lon < 0) {
            if ($lat > 0) {
                return self::$gpsAccuracyTypeCode["westNorth"][$type];
            } else# if ($lat < 0)
            {
                return self::$gpsAccuracyTypeCode["westSouth"][$type];
            }
        }
    }
    /*private function getGpsAccuracyType($timeArr , $object){
        $gpsCode = 0;
        $brand = array("T7", "T7A", "T7C", "T7V", "T7Mini");
        if(!empty($object->IsWireless) || (!empty($object->ForceTraceFlag) && in_array($object->Brand , $brand))){
            $gpsCode = 300;
        }else{
            $gpsCode = 43200;
        }
        //精准
        $accuracyTypeArr['0'] = $timeArr['gpsTime'] + $gpsCode;
        //第三方
        $accuracyTypeArr['4'] = $timeArr['mixedTime'] + 21600;
        //wifi定位
        $accuracyTypeArr['3'] = $timeArr['wifiTime'] + 300;
        //基站
        $accuracyTypeArr['2'] = $timeArr['bsTime'];
        //非精准
        $accuracyTypeArr['1'] = $timeArr['notAccuracyGPSTime'] - 120;
        $maxTime = max($accuracyTypeArr['0'] , $accuracyTypeArr['4'] , $accuracyTypeArr['3'] , $accuracyTypeArr['2'] , $accuracyTypeArr['1']);
        return array_search($maxTime,$accuracyTypeArr);
    }*/
    private static $gpsAccuracyTypeCode = array(
        'eastNorth' => array(0 => 307, 1 => 308, 2 => 318, 3 => 347, 4 => 337),
        'eastSouth' => array(0 => 305, 1 => 306, 2 => 316, 3 => 345, 4 => 335),
        'westNorth' => array(0 => 303, 1 => 304, 2 => 314, 3 => 343, 4 => 333),
        'westSouth' => array(0 => 301, 1 => 302, 2 => 312, 3 => 341, 4 => 331),
    );

    private function getTimeScheme($s , $e){
        $start = $s;
        $end = $e;
        //今天时间
        $day = strtotime(date('Y-m-d' , strtotime('+1 day'))) - 1;
        //7天以内
        $weekDay = strtotime(date('Y-m-d' , strtotime('-6 day' , $day)));
        //90天以内
        $monthDay = strtotime(date('Y-m-d' , strtotime('-89 day' , $day)));
        $time = array();
        //判断开始时间是否大于周，大于直接从第一个机房取
        if($start >= $weekDay){
            $time[0]['start'] = $s;
            $time[0]['end'] = $e;
            //判断结束时间是否在一周而且开始时间不再本周
        }else if($end >= $weekDay && $start < $weekDay){
            $time[0]['start'] = $weekDay;
            $time[0]['end'] = $e;
            //是否在90天以内，如果是直接取二号机房，否则夸3个机房
            if($start >= $monthDay){
                $time[1]['start'] = $s;
                $time[1]['end'] = $weekDay - 1;
            }else{
                $time[1]['start'] = $monthDay;
                $time[1]['end'] = $weekDay - 1;
                $time[2]['start'] = $s;
                $time[2]['end'] = $monthDay - 1;
            }
            //判断开始时间是否大于90天，如果直接从第二个机房取
        }else if($start >= $monthDay){
            $time[1]['start'] = $s;
            $time[1]['end'] = $e;
            //判断结束时间是否在90天内而且开始时间不在90天内
        }else if($end >= $monthDay && $start < $monthDay){
            $time[1]['start'] = $monthDay;
            $time[1]['end'] = $e;
            $time[2]['start'] = $s;
            $time[2]['end'] = $monthDay - 1;
            //都不匹配从最后一个机房取
        }else{
            $time[2]['start'] = $s;
            $time[2]['end'] = $e;
        }
        return $time;
    }

    private static function toStr($bytes){
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }
    /**
     * 转换一个String字符串为byte数组
     * @param $str 需要转换的字符串
     * @param $bytes 目标byte数组
     * @author Zikie
     */
    private static function getBytes($string) {
        $bytes = array();
        $len = strlen($string);
        for($i = 0; $i < $len; $i++){
            if (ord($string[$i])>128) {
                $bytes[] = ord($string[$i]) - 128 * 2;
            } else {
                $bytes[] = ord($string[$i]);
            }
        }
        return $bytes;
    }

	 /**#############################ASS模块#########################################################*/
    //获取告警数量
    public function getAlarmNum($holdID,$typeListSeq=[])
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmNum($holdID, $typeListSeq, $data, $total);
        return ['status'=>$check,'data'=>$data, 'total'=>$total];
    }

    //获取用户的报警类型列表
    public function getAlarmList($holdID,$typeListSeq,$pageNum,$pageSize)
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmList($holdID, $typeListSeq, $pageNum,$pageSize,$data,$total);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }

    //获取各省告警数量
    public function getAlarmNumByProvince($holdID,$typeListSeq)
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmNumByProvince($holdID, $typeListSeq, $data, $total);
		print_r ($data);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }

    //获取告警数量省市(传入省)
    public function getAlarmNumByCity($holdID,$typeListSeq,$Province)
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmNumByCity($holdID, $typeListSeq, $Province, $data, $total);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }

    //获取告警数量市区(传入省市)
    public function getAlarmNumByRegion($holdID,$typeListSeq,$Province,$city)
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmNumByRegion($holdID, $typeListSeq, $Province, $city, $data, $total);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }

    //获取告警类型列表（省）
    public  function getAlarmListByProvince($holdID,$typeListSeq,$pageNum,$pageSize,$province)
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmListByProvince($holdID, $typeListSeq, $pageNum, $pageSize, $province, $data, $total);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }

    //获取告警类型列表（市）
    public  function getAlarmListByCity($holdID,$typeListSeq,$pageNum,$pageSize,$province,$city)
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmListByCity($holdID, $typeListSeq, $pageNum, $pageSize, $province, $city, $data, $total);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }

    //获取告警类型列表（区）
    public  function getAlarmListByRegion($holdID,$typeListSeq,$pageNum,$pageSize ,$province, $city, $region)
    {
        $data   = [];
        $total  = 0;
        $check  = self::$ASShandle->getAlarmListByRegion($holdID, $typeListSeq, $pageNum, $pageSize, $province, $city, $region, $data, $total);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }

    //获取目标实告警信息
    public function getAlarmInfo($holdID, $objIds, $typeListSeq, $pageNum, $pageSize)
    {
        $data   = [];
        $total  = [];
        $check  = self::$ASShandle->getAlarmInfo($holdID, $objIds,$typeListSeq, $pageNum, $pageSize, $data, $total);
        return ['status'=>$check,'data'=>$data,'total'=>$total];
    }


    /**#############################Trace模块#########################################################*/
    //设置追踪总开关
    public function setOnOff($on)
    {
        $check  = self::$TRACEhandle->setOnOff($on);
        return ['status'=>$check];
    }

    //添加/重置设备追踪
    public function addTrace($param)
    {
        $obj = [];
        foreach($param as $k=> $v){
            $info = new DataStructs_TraceObject($v['imei'],$v['endTraceTime']);
            $obj[] = $info;
            $info = [];
        }
        $check  = self::$TRACEhandle->add($obj);
        return ['status'=>$check];
    }

    //删除设备追踪
    public function delTrace($param)
    {
        $check  = self::$TRACEhandle->del($param);
        return ['status'=>$check];
    }

    //查看追踪列表
    public function traceList()
    {
        $data   = (object)array();
        $check  = self::$TRACEhandle->_list($data);
        $result = [];
        $total  = 0;
        foreach($data as $val){
            $info   = [];
            $info['imei']         = $val->imei;
            if($val->endTraceTime == '-1'){
                $info['endTraceTime'] = '永久有效';
            }else {
                $info['endTraceTime'] = date('Y-m-d H:i:s',$val->endTraceTime);
            }
            $result[] = $info;
            $total ++;
        }
        return ['status'=>$check,'data'=>$result, 'total'=>$total];
    }
}
