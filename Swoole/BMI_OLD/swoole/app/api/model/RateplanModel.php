<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 11:48
 * Email: 1183@mapgoo.net
 */

namespace app\api\model;


use mapgoo\base\Config;
use mapgoo\helper\BytesHelper;
use Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingReq;
use Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanReq;
use Mapgoo\Mlb\M2maas\Request\Data\RequestInfo;

class RateplanModel extends BaseModel
{
    /**
     * 排队资费计划数据
     * @param array $req
     * @return array
     */
    public function queueTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $queueTerminalRatePlanReq = new QueueTerminalRatePlanReq();
        $queueTerminalRatePlanReq->setIccid($params['iccid']);
        $queueTerminalRatePlanReq->setRenewalRatePlan($params['renewalRatePlan']);
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setQueueTerminalRatePlanReq($queueTerminalRatePlanReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'queueTerminalRatePlan';
        }
        return $resp;
    }

    /**
     * 修改卡资费计划
     * @param array $req
     * @return array
     */
    public function editTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $editTerminalRatingReq = new EditTerminalRatingReq();
        $editTerminalRatingReq->setIccid($params['iccid']);
        if(!empty($params['termStartDate']))$editTerminalRatingReq->setTermStartDate($params['termStartDate']);
        if(!empty($params['termEndDate']))$editTerminalRatingReq->setTermEndDate($params['termEndDate']);
        if(!empty($params['renewalMode']))$editTerminalRatingReq->setRenewalMode($params['renewalMode']);
        if(!empty($params['renewalRatePlan']))$editTerminalRatingReq->setRenewalRatePlan($params['renewalRatePlan']);
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setEditTerminalRatingReq($editTerminalRatingReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'editTerminalRating';
        }
        return $resp;
    }
}