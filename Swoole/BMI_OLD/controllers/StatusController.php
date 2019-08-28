<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/9/27
 * Time: 16:46
 * Email: 1183@mapgoo.net
 */
class StatusController extends InitController
{
	
    public function getCameraAction(){
		if(empty($this->request['objID']))return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'objectID不能为空');
		$objID = (int)$this->request['objID'];
		$res = $this->domian->GetObjectinfoById($objID);
		$rep['objID'] = $objID;
		$rep['isLink'] = 0;
		$rep['cameraStatus'] = array();
		if($res['status'] === 0){
			if(!empty($res['data']->ssvid) && $res['data']->captureType == 1){
				$res = $this->domian->getCameraInfo($res['data']->ssvid);
				if($res['status'] === 0){
					foreach($res['data'] as $key=>$val){
						$rep['cameraStatus'][$key]['type'] = $val->cameraType;
						$rep['cameraStatus'][$key]['status'] = $val->cameraState;
					}
					return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'] , $rep);
				}
			}else{
				$res = $this->domian->getRedisDatas(array($objID));
				if($res['status'] === 0){
					$rep['isLink'] = !empty($res['data'][0]->isLink) ? 1 : 0;
					return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'] , $rep);
				}
			}
			return $this->jsonResponse(Api_Define::$RETURN_FALL['status'], Api_Define::$RETURN_FALL['info'] , $res);
		}else{
			return $this->jsonResponse(Api_Define::$RETURN_NOT_FOUND['status'], Api_Define::$RETURN_NOT_FOUND['info']);
		}
	}
}