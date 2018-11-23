<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/12 23:36
 * Email: 1183@mapgoo.net
 */

namespace app\api\model;


use Mapgoo\Mlb\M2maas\Request\Data\RequestBaseInfo;

class BaseModel
{
    protected $requestBase = null;

    protected function buildRequest(array $req)
    {
        $this->requestBase = new RequestBaseInfo();
        $this->requestBase->setMessageId($req['messageId']);
        $this->requestBase->setSoureType($req['soureType']);
        $this->requestBase->setSyncType($req['requestType']);
        if($req['requestType'] == 1 && !empty($req['callbackUrl'])){
            $this->requestBase->setCallbackUrl($req['callbackUrl']);
        }
        $this->requestBase->setPriority($req['priority']);
    }
}