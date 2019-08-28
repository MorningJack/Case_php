<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/6
 * Time: 16:46
 * Email: 1183@mapgoo.net
 */
class TraceController extends InitController
{
	//设置追踪总开关
    public function setOnOffAction(){
		$on = $this->request['on'];
        if (!is_bool($on)) {
            return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'on必须为bool类型');
        }
        $data = $this->domian->setOnOff($on);
		if($data['status']->errorcode != 0){
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		}else {
			$return = [];
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
    }

	//添加/重置设备追踪
	public function addTraceAction(){
		$info = $this->request['info'];
		if(empty($info) || !is_array($info)){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'info参数不能为空且必须为数组');
		}
		foreach($info as $val){
			if(empty($val['imei'])){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'imei参数不能为空');
			}
			if(!is_int($val['endTraceTime'])){
				return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'endTraceTime参数必须为时间戳');
			}
		}
		$data = $this->domian->addTrace($info);
		if($data['status']->errorcode != 0){
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		}else {
			$return = [];
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}

	//删除设备追踪
	public function delTraceAction()
	{
		$imei = $this->request['imei'];
		if(empty($imei) || !is_array($imei)){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'info参数不能为空且必须为数组');
		}
		$data = $this->domian->delTrace($imei);
		if($data['status']->errorcode != 0){
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		}else {
			$return = [];
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}

	//查看追踪列表
	public function traceListAction()
	{
		$data = $this->domian->traceList();
		if($data['status']->errorcode != 0){
			return $this->jsonResponse($data['status']->errorcode, $data['status']->errormsg);
		}else {
			$return['total']     = $data['total'] ? $data['total'] : 0;
			$return['traces']    = $data['data'];
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
	}
}