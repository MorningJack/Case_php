<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 17:02
 * Email: 1183@mapgoo.net
 */

namespace app\api\controller;

use app\api\model\SmsModel;
use app\api\validate\SmsValidate;
use mapgoo\base\ErrorCode;
use mapgoo\http\Request;
use mapgoo\http\Response;

class Sms extends Base
{
    /**
     * (通过 SIM 卡 ID)向一个设备发送短信
     * @param Request $request
     * @param Response $response
     */
    public function sendSms(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new SmsValidate();
        if(!$validate->checkSendSms($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new SmsModel())->sendSmsTaskData($req);
        $this->responseData($response, $taskData, $req['messageId'], false);
        return;
    }
}