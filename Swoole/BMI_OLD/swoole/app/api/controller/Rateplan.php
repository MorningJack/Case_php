<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 11:44
 * Email: 1183@mapgoo.net
 */

namespace app\api\controller;

use app\api\model\RateplanModel;
use app\api\validate\RateplanValidate;
use mapgoo\base\ErrorCode;
use mapgoo\http\Request;
use mapgoo\http\Response;

class Rateplan extends Base
{
    /**
     * 排队资费计划
     * @param Request $request
     * @param Response $response
     */
    public function queueTerminalRatePlan(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new RateplanValidate();
        if(!$validate->checkQueue($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new RateplanModel())->queueTaskData($req);
        $this->responseData($response, $taskData, $req['messageId'], false);
        return;
    }

    /**
     * 修改卡资费计划
     * @param Request $request
     * @param Response $response
     */
    public function editTerminalRating(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new RateplanValidate();
        if(!$validate->checkEdit($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new RateplanModel())->editTaskData($req);
        $this->responseData($response, $taskData, $req['messageId'], false);
        return;
    }
}