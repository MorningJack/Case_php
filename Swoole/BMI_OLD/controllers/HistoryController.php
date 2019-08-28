<?php 
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/10
 * Time: 9:27
 * Email: 1183@mapgoo.net
 */
class HistoryController extends InitController
{	
	
	//获取历史行程
	public function getHistoryTracksAction(){
		$request['objectID'] = !empty($this->request['objectId'])?(int)$this->request['objectId']:"";
		$request['imei'] = !empty($this->request['imei'])?$this->request['imei']:"";
		$request['startTime'] = !empty($this->request['stime']) && strtotime($this->request['stime']) !== false?strtotime($this->request['stime']):"";
		$request['endTime'] = !empty($this->request['etime']) && strtotime($this->request['etime']) !== false?strtotime($this->request['etime']):"";
		$request['speedLimit'] = !empty($this->request['speed_limit'])?(int)$this->request['speed_limit']:5;
		$request['exact'] = !empty($this->request['Exact'])?(int)$this->request['Exact']:0;
		$request['limit'] = !empty($this->request['limit'])?(int)$this->request['limit']:0;
		$verifyArr = array('startTime','endTime');
		foreach($verifyArr as $k=>$v){
			if(empty($request[$v])){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
			}
		}
		if(!$request['objectID'] && !$request['imei'])return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'objectID或imei不能为空');
		if($request['objectID'] && $request['imei'])return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_MORE_ERROR['info']);
		/*if($request['imei']){
			$request['objectID'] = 0;
			$res = $this->domian->GetObjectinfoByImei($request['imei']);
			if($res['status'] === 0){
				$request['objectID'] = empty($res['data']->ObjectID)?0:$res['data']->ObjectID;
			}
		}*/
		if ($request['startTime'] > $request['endTime']) {
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']);	
		}
		$func = SWOOLE_DEBUG ? 'RecordsTest' : 'Records';
		$rs = $this->domian->{$func}($request['objectID'], $request['startTime'], $request['endTime'], $request['speedLimit'], $request['exact'], $request['limit']);
		if(empty($rs)){
			return $this->jsonResponse(Api_Define::$DATA_RESULT_EMPTY['status'], Api_Define::$DATA_RESULT_EMPTY['info']);
		}else{
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$rs);
		}
	}


	public function uploadHistoryTracksAction() {

		$objectId = !empty($this->request['objectId']) ? (int)$this->request['objectId'] : "";
		$gpsTime  = !empty($this->request['gpsTime']) ? strtotime($this->request['gpsTime']) : "";
		$lon      = !empty($this->request['lon']) ? round($this->request['lon']*1000000) : "";
		$lat      = !empty($this->request['lat']) ? round($this->request['lat']*1000000) : "";
		$speed    = !empty($this->request['speed']) ? (int)$this->request['speed'] : 0;
		$direct   = !empty($this->request['direct']) ? (int)$this->request['direct'] : 0;

		$rcvTime  = time();

		if(empty($objectId)){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'objectId不能为空');
		}
		if(empty($gpsTime) ){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'gpsTime不能为空');
		}
		if( $gpsTime < ($rcvTime-86400) ){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'gpsTime不能小于当前时间24小时');
		}
		if( $gpsTime > $rcvTime ){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'gpsTime不能超过当前时间');
		}
		if($lon <= 0 || $lat <= 0 || empty($lon) || empty($lat)){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'lon,lat格式错误');
		}

		if($speed < 0 || $direct < 0 ){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'speed,direct不能小于0');
		}

		$rs  = $this->domian->addRecords((int)$objectId, (int)$rcvTime, (int)$gpsTime, (int)$lon, (int)$lat ,$speed, $direct);
		if($rs['status'] != 0){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . '轨迹上传失败');
		}else{
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$rs);
		}

	}
}
?>