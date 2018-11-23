<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 15:38
 * Email: 1183@mapgoo.net
 */

namespace app\api\model;


use mapgoo\base\Config;
use mapgoo\helper\BytesHelper;
use Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsReq;
use Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageReq;
use Mapgoo\Mlb\M2maas\Request\Data\RequestInfo;

class TerminalUsageModel extends BaseModel
{
    /**
     * 获取设备当前用量明细
     * @param array  $req  请求参数
     * @return array
     */
    public function getDetailTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $getTerminalUsageDataDetailsReq = new GetTerminalUsageDataDetailsReq();
        $getTerminalUsageDataDetailsReq->setIccid($params['iccid']);
        if(!empty($params['pageNumber']))$getTerminalUsageDataDetailsReq->setPageNumber($params['pageNumber']);
        $cycleStartDate = date('Y-m-d', strtotime($params['cycleStartDate']));
        $getTerminalUsageDataDetailsReq->setCycleStartDate($cycleStartDate);
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setGetTerminalUsageDataDetailsReq($getTerminalUsageDataDetailsReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'getTerminalUsageDataDetails';
        }
        return $resp;
    }

    /**
     * 获取设备当前用量
     * @param array $req
     * @return array
     */
    public function getTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $getTerminalUsageReq = new GetTerminalUsageReq();
        $getTerminalUsageReq->setIccid($params['iccid']);
        if(!empty($params['cycleStartDate'])){
            $cycleStartDate = date('Y-m-d', strtotime($params['cycleStartDate']));
            $getTerminalUsageReq->setCycleStartDate($cycleStartDate);
        }
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setGetTerminalUsageReq($getTerminalUsageReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'getTerminalUsage';
        }
        return $resp;
    }
}