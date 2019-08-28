<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/6
 * Time: 16:46
 * Email: 1183@mapgoo.net
 */
class TrackController extends InitController
{
    /**
     *获取目标实时数据
     *
     *存在问题：目前没有存IsOBD，ObjectName字段
     */
    public function getObjectCurrentTrackAction()
    {	
        if (empty($this->request['objID'])) {
            return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'objID不能为空');
        }
        $objIDs[] = (int)$this->request['objID'];
        $result = $this->domian->getRealDatas($objIDs);
		if(empty($result)){
			return $this->jsonResponse(Api_Define::$DATA_RESULT_EMPTY['status'], Api_Define::$DATA_RESULT_EMPTY['info']);
		}else{
			$return = current($result);
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$return);
		}
    }


    /**
     *批量获取目标实时数据
     *存在问题：目前没有存IsOBD，ObjectName字段
     */
    public function getMultipleObjectCurrentTracksAction(){
        if (empty($this->request['objIDs'])) {
            return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'objIDs不能为空');
        }
		$objIDs = $this->request['objIDs'];
		foreach($objIDs as $k=>$v){
			$objIDs[$k] = (int)$v;
		}
        $result = $this->domian->getRealDatas($objIDs);
		return empty($result)?$this->jsonResponse(Api_Define::$DATA_RESULT_EMPTY['status'], Api_Define::$DATA_RESULT_EMPTY['info']):$this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$result);
    } 
}
