<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/10
 * Time: 9:27
 * Email: 1183@mapgoo.net
 */
class ObjectController extends InitController
{
    /**
     * 批量获取目标实告警
     *
     * 存在问题：统计模块和最终数据有所出入，遍历匹配速度很慢
     */
    public function getHoldAlarmListByObjIdAlarmTypeIdAction(){
		$verifyArr = array( 'holdID', 'alarmTypeID' , 'pageSize', 'pageNum' );
		foreach($verifyArr as $k=>$v){
			$val = empty($this->request[$v])?0:(int)$this->request[$v];
			if(empty($val)){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		$holdID      = (int)$this->request['holdID'];
		$objIDs      = isset($this->request['objIDs']) ? $this->request['objIDs'] : [];
		$alarmTypeID = $this->request['alarmTypeID'] == -1 ? [] : [$this->request['alarmTypeID']];
		$pageNum     =  (int)$this->request['pageNum'];
		$pageSize    = (int)$this->request['pageSize'];

		$data = $this->domian->getAlarmInfo($holdID,$objIDs,$alarmTypeID,$pageNum,$pageSize);

		if($data['status']->errorcode != 0){
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		}else {
			$result = [];
			$info   = [];
			foreach($data['data'] as $val){
				$info['Lat']         = $val->lat/1000000;
				$info['Lon']         = $val->lng/1000000;
				$info['Direct']      = $val->direction;
				$info['Speed']       = $val->speed;
				$info['GPSTime']     = date('Y-m-d H:i:s',$val->gpsTime);
				$info['RcvTime']     = date('Y-m-d H:i:s',$val->createTime);
				$info['AlarmID']     = $val->id;
				$info['AlarmTypeID'] = $val->type;
				$info['ObjectID']    = $val->objId;
				$result[] = $info;
			}
			$return['total']      = $data['total'] ? $data['total'] : 0;
			$return['recordList'] = $result;
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}
	public function getHoldObjIdListByStatisticsTypeAction()
    {	
		$verifyArr = array("holdID","statisticsType","pageNum","pageSize");
		foreach($verifyArr as $k=>$v){
			$val = empty($this->request[$v])?0:(int)$this->request[$v];
			if(empty($val)){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		$params = array('holdID' => $this->request['holdID'], 'pageSize' => $this->request['pageSize'], 'pageNum' => $this->request['pageNum'], 'statisticsType' => $this->request['statisticsType']);
		if($this->request['statisticsType'] == 3){
			$iceData = $this->domian->getAlarmList($params['holdID'],[],$params['pageNum'],$params['pageSize']);
		}else{
			$iceData = $this->domian->getObjsByHoldId($params);
		}
		if ($iceData['status']->errorcode != 0) {
			return $this->jsonResponse($iceData['status']->errorcode, $iceData['status']->errormsg);
		}else {
			$return = array();
			$return['total'] = $iceData['total'];
			$return['objIDList'] = $iceData['data'];
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
    }
}
