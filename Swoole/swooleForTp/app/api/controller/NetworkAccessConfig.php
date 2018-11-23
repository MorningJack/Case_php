<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/13 14:22
 * Email: 1183@mapgoo.net
 */

namespace app\api\controller;

use app\api\model\NetworkAccessConfigModel;
use app\api\validate\NetworkAccessValidate;
use mapgoo\base\ErrorCode;
use mapgoo\http\Request;
use mapgoo\http\Response;

class NetworkAccessConfig extends Base
{
    /**
     * 获取设备当前的通讯网络配置
     * @param Request $request
     * @param Response $response
     */
    public function getNetworkAccessConfig(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new NetworkAccessValidate();
        if(!$validate->checkGet($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new NetworkAccessConfigModel())->getTaskData($req);
        $this->responseData($response, $taskData, $req['messageId']);
        return;
    }

    /**
     * 修改设备通信网络配置
     * @param Request $request
     * @param Response $response
     */
    public function editNetworkAccessConfig(Request $request, Response $response)
    {
        $req = $this->requestData($request);
        $validate = new NetworkAccessValidate();
        if(!$validate->checkEdit($req)){
            $response->response(ErrorCode::PARAM_ERROR, $validate->getError(), $req['messageId'])->send();
            return;
        }
        $taskData = (new NetworkAccessConfigModel())->editTaskData($req);
        $this->responseData($response, $taskData, $req['messageId'], false);
        return;
    }
}