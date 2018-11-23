<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/12 20:08
 * Email: 1183@mapgoo.net
 */

namespace app\api\controller;


use app\api\model\TerminalModel;
use app\api\validate\TerminalValidate;
use mapgoo\base\ErrorCode;
use mapgoo\http\Request;
use mapgoo\http\Response;

class Terminal extends Base
{
    /**
     * 设备修改
     * @param Request $request
     * @param Response $response
     */
    public function editTerminal(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new TerminalValidate();
        if(!$validate->checkEdit($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new TerminalModel())->editTaskData($req);
        $this->responseData($response, $taskData, $req['messageId'], false);
        return;
    }

    /**
     * 获取设备详情
     * @param Request $request
     * @param Response $response
     */
    public function getTerminalDetails(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new TerminalValidate();
        if(!$validate->checkGet($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new TerminalModel())->getTaskData($req);
        $this->responseData($response, $taskData, $req['messageId']);
        return;
    }

    /**
     * 获取数据有变更过的卡
     * @param Request $request
     * @param Response $response
     */
    public function getModified(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $taskData = (new TerminalModel())->getModifiedTaskData($req);
        $this->responseData($response, $taskData, $req['messageId']);
        return;
    }

    /**
     * 获取基本资费计划和所有排队资费计划
     * @param Request $request
     * @param Response $response
     */
    public function getTerminalRating(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new TerminalValidate();
        if(!$validate->checkGetRating($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new TerminalModel())->getRatingTaskData($req);
        $this->responseData($response, $taskData, $req['messageId']);
        return;
    }

    /**
     * 获取账单详情
     * @param Request $request
     * @param Response $response
     */
    public function getTerminalAuditTrail(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new TerminalValidate();
        if(!$validate->checkGetAuditTrail($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new TerminalModel())->getAuditTrailTaskData($req);
        $this->responseData($response, $taskData, $req['messageId']);
        return;
    }
}