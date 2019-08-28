<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 13:07
 * Email: 1183@mapgoo.net
 */

namespace app\api\model;


use mapgoo\base\Config;
use mapgoo\helper\BytesHelper;
use Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoReq;
use Mapgoo\Mlb\M2maas\Request\Data\RequestInfo;

class SessionModel extends BaseModel
{
    /**
     * 获取设备会话信息
     * @param array  $req  请求参数
     * @return array
     */
    public function getTaskData(array $req = []):array
    {
        $params = $req['params'];
        $this->buildRequest($req);
        $getSessionInfoReq = new GetSessionInfoReq();
        foreach ($params['iccid'] as $iccid){
            $getSessionInfoReq->appendIccid($iccid);
        }
        $requestInfo = new RequestInfo();
        $requestInfo->setBaseInfo($this->requestBase);
        $requestInfo->setGetSessionInfoReq($getSessionInfoReq);
        $resp['op'] = $req['requestType'] ? 1 : 0;
        $resp['message'] = BytesHelper::getBytes($requestInfo->serializeToString());
        if($resp['op']){
            $resp['exchange'] = Config::get('exchange.source') . '.' . $req['soureType'];
            $resp['option'] = ['priority' => $req['priority']];
        }else{
            $resp['handle'] = 'bss';
            $resp['action'] = 'getSessionInfo';
        }
        return $resp;
    }
}