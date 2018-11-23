<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 15:33
 * Email: 1183@mapgoo.net
 */

namespace app\api\controller;

use app\api\model\TerminalUsageModel;
use app\api\validate\TerminalUsageValidate;
use mapgoo\base\ErrorCode;
use mapgoo\http\Request;
use mapgoo\http\Response;

class TerminalUsage extends Base
{
    /**
     * 获取设备当前用量明细
     * @param Request $request
     * @param Response $response
     */
    public function getTerminalUsageDataDetails(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new TerminalUsageValidate();
        if(!$validate->checkGetDetail($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new TerminalUsageModel())->getDetailTaskData($req);
        $this->responseData($response, $taskData, $req['messageId']);
        return;
    }

    /**
     * 获取设备用量
     * @param Request $request
     * @param Response $response
     */
    public function getTerminalUsage(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new TerminalUsageValidate();
        if(!$validate->checkGet($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new TerminalUsageModel())->getTaskData($req);
        $this->responseData($response, $taskData, $req['messageId'], false);
        return;
    }
}