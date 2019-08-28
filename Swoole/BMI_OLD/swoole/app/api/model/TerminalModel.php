<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/12 20:23
 * Email: 1183@mapgoo.net
 */

namespace app\api\model;


use mapgoo\base\Config;
use mapgoo\helper\BytesHelper;
use Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsReq;
use Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailReq;
use Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailReq;
use Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingReq;
use Mapgoo\Mlb\M2maas\Request\Data\RequestInfo;
use Mapgoo\Mlb\M2maas\Request\Data\TerminalEditReq;

class TerminalModel extends BaseModel
{
    /**
     * 设备修改数据
     * @param array  $req  请求参数
     * @return array
     */
    public function editTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $terminalEditReq = new TerminalEditReq();
        $terminalEditReq->setIccid($params['iccid']);
        $terminalEditReq->setChangeType($params['changeType']);
        if(!empty($params['targetValue']))$terminalEditReq->setTargetValue($params['targetValue']);
        if(!empty($params['effectiveDate'])){
            $effectiveDate = date('Y-m-d', strtotime($params['effectiveDate']));
            $terminalEditReq->setEffectiveDate($effectiveDate);
        }
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setTerminalEditReq($terminalEditReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'editTerminal';
        }
        return $resp;
    }

    /**
     * 获取设备详情
     * @param array $req 请求参数
     * @return array
     */
    public function getTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $getTerminalDetailReq = new GetTerminalDetailReq();
        foreach ($params['iccids'] as $value){
            $getTerminalDetailReq->appendIccids($value);
        }
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setGetTerminalDetailReq($getTerminalDetailReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'getTerminalDetails';
        }
        return $resp;
    }

    /**
     * 获取数据有变更过的卡
     * @param array $req
     * @return array
     */
    public function getModifiedTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $getModifiedTerminalsReq = new GetModifiedTerminalsReq();
        if(!empty($params['since']))$getModifiedTerminalsReq->setSince($params['since']);
        if(!empty($params['simState']))$getModifiedTerminalsReq->setSimState($params['simState']);
        if(!empty($params['pageNumber']))$getModifiedTerminalsReq->setPageNumber($params['pageNumber']);
        if(!empty($params['accountId']))$getModifiedTerminalsReq->setAccountId($params['accountId']);
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setGetModifiedTerminalsReq($getModifiedTerminalsReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'getModifiedTerminals';
        }
        return $resp;
    }

    /**
     * 获取基本资费计划和所有排队资费计划
     * @param array $req
     * @return array
     */
    public function getRatingTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $getTerminalRatingReq = new GetTerminalRatingReq();
        $getTerminalRatingReq->setIccid($params['iccid']);
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setGetTerminalRatingReq($getTerminalRatingReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'getTerminalRating';
        }
        return $resp;
    }

    /**
     * 获取账单详情
     * @param array $req
     * @return array
     */
    public function getAuditTrailTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $getTerminalAuditTrailReq = new GetTerminalAuditTrailReq();
        $getTerminalAuditTrailReq->setIccid($params['iccid']);
        if(!empty($params['daysOfHistory']))$getTerminalAuditTrailReq->setDaysOfHistory($params['daysOfHistory']);
        if(!empty($params['date']))$getTerminalAuditTrailReq->setDate($params['date']);
        if(!empty($params['pageNumber']))$getTerminalAuditTrailReq->setPageNumber($params['pageNumber']);
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setGetTerminalAuditTrailReq($getTerminalAuditTrailReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'getTerminalAuditTrail';
        }
        return $resp;
    }
}