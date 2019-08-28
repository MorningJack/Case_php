<?php

/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/5/19 17:30
 * Email: 1183@mapgoo.net
 */
class LiveController extends InitController
{
    public function getUrlAction(){
        $verifyArr = array('ssvid', 'imei');
        foreach($verifyArr as $k=>$v){
            if(empty($this->request[$v])){
                return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
            }
        }
        $res = $this->domian->getVideoLiveInfo($this->request['ssvid']);
        if($res['status'] === 0){
            if(!empty($res['data'][0]->url)){
                $response['ssvid'] = $this->request['ssvid'];
                $response['imei']  = $this->request['imei'];
                $response['url']   = $res['data'][0]->url;
                return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'] , $response);
            }
            return $this->jsonResponse(Api_Define::$RETURN_FALL['status'], Api_Define::$RETURN_FALL['info']);
        }else{
            return $this->jsonResponse($res['status'], Api_Define::$RETURN_FALL['info']);
        }
    }
}