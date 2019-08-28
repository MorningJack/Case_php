<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/6
 * Time: 17:28
 * Email: 1183@mapgoo.net
 */
class StatisticsController extends InitController
{

    /**
     * 报警统计数据动态获取
     */
    public function getHoldObjStatisticsByAlarmTypeGroupAction(){
        if (empty($this->request['holdID'])) {
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'holdID不能为空');
		}
		$params = array(
			'holdID' => intval($this->request['holdID']),
			'statisticsType' =>3,
			'pageSize' =>100000,
			'pageNum'=>1
		);
		$data = $this->domian->getAlarmNum($params['holdID'],[]);
		if ($data['status']->errorcode != 0) {
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		} else {
			//去掉1092的告警类型
			$info   = [];
			$result = [];
			foreach($data['data'] as $key => $val){
				if($key != 1092){
					$info['alarmTypeID'] = $key;
					$info['alarmCount']  = $val;
					$result[] = $info;
				}
			}
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$result);
		}
    }

	//获取目标统计(所有状态)
    public function getHoldObjStatisticsAction(){
       if (empty($this->request['holdID'])) {
            return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'holdID不能为空');
        }
		$data = $this->domian->getStatisticsByHoldId((int)$this->request['holdID']);
		if ($data['status']->errorcode != 0) {
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		} else {
			$data['data'] = json_decode(json_encode($data['data']), true);
			foreach ($data['data']['statistics'] as $k => $v) {
				$data['data'][$k] = $v;
			}
			unset($data['data'] ['statistics']);
			foreach ($data['data'] as $k => $v) {
				$data['data'][$k . 'Count'] = $v;
				unset($data['data'][$k]);

			}
			$data['data']['totalCount'] = $data['data']['offlineCount'] + $data['data']['onlineCount'] + $data['data']['invalidCount'] + $data['data']['sleepCount'];
			
			//alarmCount
			$org = $this->domian->getAlarmNum((int)$this->request['holdID'],[]);
			$data['data']['alarmCount'] = $org['total'];

			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$data['data']);
		}
    }
	//获取各省目标统计
    public function getHoldObjCountByStatisticsTypeProvinceGroupAction(){
		if (empty($this->request['holdID'])) {
            return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'holdID不能为空');
        }
		$param = array(
			"holdID"       => (int)$this->request['holdID'],
			"districtType" => 0 ,
			"districtName" => ''
		);
		$datas = $this->domian->getCountBydistrictName($param);
		if(!empty($datas)){

			//获取各省告警数量
			$data = $this->domian->getAlarmNumByProvince($param['holdID'],[]);
			if($data['status']->errorcode != 0){
				return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
			}
			$province_info = $data['data'];
			foreach($datas as $key => $val){
				$datas[$key]['alarmCount'] = 0;
				foreach($province_info as $k=>$v){
					if($k == $val['provinceName'] ){
						$datas[$key]['alarmCount'] = $v;
						continue;
					}
				}
			}

			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$datas);
		}else{
			return $this->jsonResponse(Api_Define::$DATA_RESULT_EMPTY['status'], Api_Define::$DATA_RESULT_EMPTY['info']);
		}
	}
	//获取省辖市目标统计
	public function getHoldObjCountByStatisticsTypeCityOfProviceGroupAction(){
		$verifyArr = array('holdID', 'provinceCode');
		foreach($verifyArr as $k=>$v){
			$value = (int)$this->request[$v];
			if(empty($value)){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		$province = $this->domian->getRegionByID((int)$this->request['provinceCode']);
		$provinceName = !empty($province['province']) ? $province['province'] : "";
		if(!$provinceName)return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']);
		$param = array(
			"holdID"       => (int)$this->request['holdID'],
			"districtType" => 1,
			"districtName" => $provinceName
		);
		$datas = $this->domian->getCountBydistrictName($param);
		if(!empty($datas)){

			//获取省辖市告警数量
			$data = $this->domian->getAlarmNumByCity($param['holdID'],[],$province['province']);
			if($data['status']->errorcode != 0){
				return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
			}
			$city_info = $data['data'];
			foreach($datas as $key => $val){
				$datas[$key]['alarmCount'] = 0;
				foreach($city_info as $k=>$v){
					if($k == $val['cityName'] ){
						$datas[$key]['alarmCount'] = $v;
						continue;
					}
				}
			}

			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$datas);
		}else{
			return $this->jsonResponse(Api_Define::$DATA_RESULT_EMPTY['status'], Api_Define::$DATA_RESULT_EMPTY['info']);
		}
	}
	//获取市辖区目标统计
	public function getHoldObjCountByStatisticsTypeRegionOfCityGroupAction(){
		$verifyArr = array('holdID', 'cityCode');
		foreach($verifyArr as $k=>$v){
			$value = (int)$this->request[$v];
			if(empty($value)){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		$city = $this->domian->getRegionByID((int)$this->request['cityCode']);
		$cityName = !empty($city['city']) ? $city['province'] . "-" . $city['city'] : "0-0";
		if(!$cityName)return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']);
		$param = array(
			"holdID"       => (int)$this->request['holdID'],
			"districtType" => 2,
			"districtName" => $cityName,
			"cityName" => $city['city'],
		);
		$datas = $this->domian->getCountBydistrictName($param);
		if(!empty($datas)){

			//获取市辖区告警数量
			$data = $this->domian->getAlarmNumByRegion($param['holdID'],[],$city['province'],$city['city']);
			if($data['status']->errorcode != 0){
				return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
			}
			$region_info = $data['data'];
			foreach($datas as $key => $val){
				$datas[$key]['alarmCount'] = 0;
				foreach($region_info as $k=>$v){
					if($k == $val['regionName'] ){
						$datas[$key]['alarmCount'] = $v;
						continue;
					}
				}
			}

			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$datas);
		}else{
			return $this->jsonResponse(Api_Define::$DATA_RESULT_EMPTY['status'], Api_Define::$DATA_RESULT_EMPTY['info']);
		}
	}
	//获取省目标列表
	public function getHoldObjIdListByStatisticsTypeProvinceGroupAction(){
		$verifyArr = array('holdID', 'statisticsType','provinceCode','pageSize','pageNum');
		foreach($verifyArr as $k=>$v){
			$value = (int)$this->request[$v];
			if(empty($value)){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		$province = $this->domian->getRegionByID((int)$this->request['provinceCode']);
		$provinceName = !empty($province['province']) ? $province['province'] : "";
		if(!$provinceName)return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']);
		$param = array(
			"holdID"       => (int)$this->request['holdID'],
			"statisticsType" => (int)$this->request['statisticsType'],
			"districtName" => $provinceName,
			"districtType" => 0,
			"pageSize" => $this->request['pageSize'],
			"pageNum" => $this->request['pageNum']
		);

		//statisticsType = 3 表示告警
		if($param['statisticsType'] ==3){
			$datas = $this->domian->getAlarmListByProvince($param['holdID'],[],$param['pageNum'],$param['pageSize'],$province['province']);
		}else {
			$datas = $this->domian->getObjsBydistrictName($param);
		}

		if ($datas['status']->errorcode != 0) {
			return $this->jsonResponse($datas['status']->errorcode, $datas['status']->errormsg);
		} else {
			$return = array();
			$return['total'] = $datas['total']?$datas['total']:0;
			$return['objIDList'] = !empty($datas['data'])?$datas['data']:array();
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}
	//获取省辖市目标列表
	public function getHoldObjIdListByStatisticsTypeCityOfProvinceGroupAction(){
		$verifyArr = array('holdID', 'statisticsType','cityCode','pageSize','pageNum');
		foreach($verifyArr as $k=>$v){
			$value = (int)$this->request[$v];
			if(empty($value)){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		$city = $this->domian->getRegionByID((int)$this->request['cityCode']);
		$cityName = !empty($city['city']) ? $city['province'] . "-" . $city['city'] : "0-0";
		if(!$cityName)return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']);

		$param = array(
			"holdID"       => (int)$this->request['holdID'],
			"statisticsType" => (int)$this->request['statisticsType'],
			"districtName" => $cityName,
			"districtType" => 1,
			"pageSize" => $this->request['pageSize'],
			"pageNum" => $this->request['pageNum']
		);
		$datas = $this->domian->getObjsBydistrictName($param);
		
		//statisticsType = 3 表示告警
		if($param['statisticsType'] == 3){
			$datas = $this->domian->getAlarmListByCity($param['holdID'],[],$param['pageNum'],$param['pageSize'],$city['province'],$city['city']);
		}else {
			$datas = $this->domian->getObjsBydistrictName($param);
		}

		if ($datas['status']->errorcode != 0) {
			return $this->jsonResponse($datas['status']->errorcode, $datas['status']->errormsg);
		} else {
			$return['total'] = $datas['total']?$datas['total']:0;
			$return['objIDList'] = !empty($datas['data'])?$datas['data']:array();
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}
	//获取市辖区目标列表
	public function getHoldObjIdListByStatisticsTypeRegionOfCityGroupAction(){
		$verifyArr = array('holdID', 'statisticsType','regionCode','pageSize','pageNum');
		foreach($verifyArr as $k=>$v){
			$value = (int)$this->request[$v];
			if(empty($value)){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		$region = $this->domian->getRegionByID((int)$this->request['regionCode']);
		$regionName = !empty($region['region']) ? $region['province'] . "-" .$region['city'] . "-" . $region['region'] : "0-0-0";
		if(!$regionName)return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']);

		$param = array(
			"holdID"       => (int)$this->request['holdID'],
			"statisticsType" => (int)$this->request['statisticsType'],
			"districtName" => $regionName,
			"districtType" => 2,
			"pageSize" => $this->request['pageSize'],
			"pageNum" => $this->request['pageNum']
		);
		$datas = $this->domian->getObjsBydistrictName($param);

		//statisticsType = 3 表示告警
		if($param['statisticsType'] == 3) {
			$datas = $this->domian->getAlarmListByRegion($param['holdID'], [], $param['pageNum'], $param['pageSize'], $region['province'], $region['city'], $region['region']);
		}else {
			$datas = $this->domian->getObjsBydistrictName($param);
		}

		if ($datas['status']->errorcode != 0) {
			return $this->jsonResponse($datas['status']->errorcode, $datas['status']->errormsg);
		} else {
			$return['total'] = $datas['total']?$datas['total']:0;
			$return['objIDList'] = !empty($datas['data'])?$datas['data']:array();
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}

	//获取用户的报警类型列表
	public function getObjsByAlarmTypesAction()
	{
		if (empty($this->request['holdId'])  ) {
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'holdID不能为空');
		}
		if (!is_array($this->request['alarmTypeIds']) ) {
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'alarmTypeIds必须为数组');
		}
		if (!is_int($this->request['pageNum']) || $this->request['pageNum']<=0 ) {
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'pageNum必须为正整数');
		}
		if (!is_int($this->request['pageSize'])|| $this->request['pageSize']<=0) {
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'pageSize必须为正整数');
		}

		$data = $this->domian->getAlarmList((int)$this->request['holdId'],(array)$this->request['alarmTypeIds'],(int)$this->request['pageNum'],(int)$this->request['pageSize']);
		if($data['status']->errorcode != 0){
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		}else {
			$return['total']     = $data['total'] ? $data['total'] : 0;
			$return['objIDList'] = $data['data'];
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}
}