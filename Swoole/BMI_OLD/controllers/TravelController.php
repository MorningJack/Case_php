<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/6
 * Time: 16:46
 * Email: 1183@mapgoo.net
 */
class TravelController extends InitController
{
	//获取最后一笔行程信息
    public function getObjCurrentTravelAction(){
		$objID = $this->request['objID'];
        if (empty($objID)) {
            return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info'] . 'objID不能为空');
        }
		$datas = $this->domian->getActiveTravel((int)$objID);
		$info = [];
		if(!empty($datas['data'])){
			$data = $datas['data'];
			$info['Complete'] = empty($data->isCompleted)?0:1;
			$info['Remark'] = !empty($data->remark)?$data->remark:"";
			$info['StartLon'] = !empty($data->startPos->point->lng)?number_format($data->startPos->point->lng/ 1000000.0, 6):0;
			$info['StartLat'] = !empty($data->startPos->point->lat)?number_format($data->startPos->point->lat/ 1000000.0, 6):0;
			$info['StartTime'] =  !empty($data->startPos->gpsTime) && $data->startPos->gpsTime>0?date('Y-m-d H:i:s',$data->startPos->gpsTime):"";
			$info['StartMileage'] = !empty($data->startPos->mileage)?round($data->startPos->mileage/1000,3):0;
			$info['BDCount'] = isset($data->seqFaultCode) ? count($data->seqFaultCode) : 0;
			$info['BDCode']  = isset($data->seqFaultCode) ? implode('，',$data->seqFaultCode) : '';
			$info['StopLon'] = !empty($data->stopPos->point->lng)?number_format($data->stopPos->point->lng/ 1000000.0, 6):0;
			$info['StopLat'] = !empty($data->stopPos->point->lat)?number_format($data->stopPos->point->lat/ 1000000.0, 6):0;
			$info['StopTime'] =  !empty($data->stopPos->gpsTime) && $data->stopPos->gpsTime>0?date('Y-m-d H:i:s',$data->stopPos->gpsTime):0;
			$info['AvgSpeed']      = !empty($data->avgSpeed) ? $data->avgSpeed : 0;//km/h
			$info['MaxSpeed']      = !empty($data->maxSpeed) ? $data->maxSpeed : 0;//km/h
			$info['posCount']      = !empty($data->posCount) ? $data->posCount : 0;
			$info['TravelMileage'] = !empty($data->travelMileage) ? number_format($data->travelMileage/1000,3) : 0;//KM
			$info['TravelPeriod']  = !empty($data->travelPeriod) ? $data->travelPeriod : 0;
		}
		return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'],$info);
    }
}