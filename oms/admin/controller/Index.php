<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 18:13
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;

use app\admin\model\OrderModel;
use app\admin\model\TotalModel;
use app\admin\model\UserModel;

class Index
{
    public function todayNum()
    {
        $orderModel = new OrderModel();
        $todayNum = $orderModel->today()->count();
        $res['count'] = !empty($todayNum) ? $todayNum : 0;
        $res['list'] = (new TotalModel())->getWeekTotal('orderNum');
        ajax_info(0, 'success', $res);
    }

    public function todayMoney()
    {
        $where = ['orderState' => ['in', '1,2,3']];
        $orderModel = new OrderModel();
        $todayMoney = $orderModel->today($where)->sum('reward');
        $res['count'] = !empty($todayMoney) ? moneyConvert($todayMoney) : 0;
        $res['list'] = (new TotalModel())->getWeekTotal('orderMoney');
        ajax_info(0, 'success', $res);
    }

    public function todayReg()
    {
        $userModel = new UserModel();
        $where['regTime'] = ['egt', date('Y-m-d')];
        $todayNum = $userModel->today($where)->count();
        $res['count'] = !empty($todayNum) ? $todayNum : 0;
        $res['list'] = (new TotalModel())->getWeekTotal('regUser');
        ajax_info(0, 'success', $res);
    }

    public function todayActive()
    {
        $userModel = new UserModel();
        $where['loginTime'] = ['egt', date('Y-m-d')];
        $todayNum = $userModel->today($where)->count();
        $res['count'] = !empty($todayNum) ? $todayNum : 0;
        $res['list'] = (new TotalModel())->getWeekTotal('activeUser');
        ajax_info(0, 'success', $res);
    }

    public function orderState()
    {
        $orderModel = new OrderModel();
        $res = $orderModel->orderState();
        ajax_info(0, 'success', $res);
    }

    public function orderMoney()
    {
        $orderModel = new OrderModel();
        $res = $orderModel->orderMoney();
        ajax_info(0, 'success', $res);
    }

    public function userIncome()
    {
        $res = (new UserModel())->userIncome();
        ajax_info(0, 'success', $res);
    }

    public function taskNum()
    {
        $res = (new UserModel())->taskNum();
        ajax_info(0, 'success', $res);
    }
}
