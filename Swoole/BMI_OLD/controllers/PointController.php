<?php

/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/1 17:06
 * Email: 1183@mapgoo.net
 */
class PointController extends InitController
{
    public function getRegionInfoAction()
    {
        $verifyArr = array('lon', 'lat');
        foreach($verifyArr as $k=>$v){
            if(empty($this->request[$v])){
                return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
            }
        }
        $res = $this->domian->gerRegionByPoint($this->request);
        if($res['status'] === 0){
            $info['regionName'] = $res['data']->regionName;
            $info['cityName'] = $res['data']->cityName;
            $info['provinceName'] = $res['data']->provinceName;
            return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'], $info);
        }else{
            return $this->jsonResponse(Api_Define::$DATA_RESULT_EMPTY['status'], Api_Define::$DATA_RESULT_EMPTY['info']);
        }
    }

    public function getAddressAction()
    {
        $verifyArr = array('lon', 'lat');
        foreach($verifyArr as $k=>$v){
            if(empty($this->request[$v])){
                return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . $v .'不能为空');
            }
        }

        $res = $this->domian->gerRegionByPoint($this->request);
        if($res['status'] === 0){
            $id   = $this->domian->getRegionIDByName($res['data']->cityName,$res['data']->regionName,2);//获取区域的id
            $info = [
                ['dtype'=>'recid','name'=>$id],
                ['dtype'=>'province','name'=>$res['data']->provinceName],
                ['dtype'=>'city','name'=>$res['data']->cityName],
                ['dtype'=>'region','name'=>$res['data']->regionName],
            ];
            return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'], $info);
        }else{
            $info = [
                ['dtype'=>'recid','name'=>'-1'],
                ['dtype'=>'province','name'=>''],
                ['dtype'=>'city','name'=>''],
                ['dtype'=>'region','name'=>''],
            ];
            return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$info);
        }
    }
}