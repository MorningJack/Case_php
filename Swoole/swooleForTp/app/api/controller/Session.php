<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 13:04
 * Email: 1183@mapgoo.net
 */

namespace app\api\controller;


use app\api\model\SessionModel;
use app\api\validate\SessionValidate;
use mapgoo\base\ErrorCode;
use mapgoo\http\Request;
use mapgoo\http\Response;

class Session extends Base
{
    /**
     * 修改卡资费计划
     * @param Request $request
     * @param Response $response
     */
    public function getSessionInfo(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new SessionValidate();
        if(!$validate->checkGet($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new SessionModel())->getTaskData($req);
        $this->responseData($response, $taskData, $req['messageId']);
        return;
    }
}