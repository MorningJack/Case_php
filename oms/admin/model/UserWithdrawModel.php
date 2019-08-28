<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/3 9:09
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use think\Model;

class UserWithdrawModel extends Model
{
    protected $table = 'b_user_withdraw';
    protected $pk = 'wid';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';

    protected $userModel = 'b_user';

    public function withdrawList($req){
        $where = [];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['w.createTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['state']){
            switch ($req['state']){
                case 1:
                    $where['w.state'] = 0;
                    break;
                case 2:
                    $where['w.state'] = 1;
                    break;
                case 3:
                    $where['w.state'] = 2;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'userName'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $withdrawArr = $this->alias('w')
                    ->join($this->userModel . ' u' , 'w.uid = u.uid' , 'LEFT')
                    ->field('w.* , u.userName name, u.mobile')
                    ->where($where)
                    ->order('createTime DESC')
                    ->page($req['pageNum'] , $req['pageSize'])
                    ->select();
        $total      = $this->alias('w')
                    ->join($this->userModel . ' u' , 'w.uid = u.uid' , 'LEFT')
                    ->where($where)
                    ->count();
        $withdrawList = [];
        $pageNum = ($req['pageNum'] - 1) * $req['pageSize'];
        foreach ($withdrawArr as $k => $info){
            $withdraw = $info->getData();
            $withdraw['name'] = $withdraw['name'] ? $withdraw['name'] : '';
            $withdraw['mobile'] = $withdraw['mobile'] ? $withdraw['mobile'] : '';
            $withdraw['reason'] = $withdraw['reason'] ? $withdraw['reason'] : '';
            $withdraw['channel'] = $withdraw['channel'] == 1 ? '微信' : '支付宝';
            $withdraw['money'] = moneyConvert($withdraw['money']);
            $withdraw['balance'] = moneyConvert($withdraw['balance']);
            $withdraw['transaction'] = $withdraw['transaction'] ? $withdraw['transaction'] : '';
            if($withdraw['state'] != 1)$withdraw['updateTime'] = '';
            if($withdraw['state'] == 0){
                $withdraw['state'] = '提现中';
            }elseif ($withdraw['state'] == 1){
                $withdraw['state'] = '提现成功';
            }else{
                $withdraw['state'] = '提现失败';
            }
            $withdraw['rowIndex'] = ($pageNum + $k) + 1;
            $withdrawList[] = $withdraw;
        }
        return ['total' => $total , 'list' => $withdrawList];
    }

    public function withdrawExport($req){
        $where = [];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['w.createTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['state']){
            switch ($req['state']){
                case 1:
                    $where['w.state'] = 0;
                    break;
                case 2:
                    $where['w.state'] = 1;
                    break;
                case 3:
                    $where['w.state'] = 2;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'userName'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $withdrawArr = $this->alias('w')
            ->join($this->userModel . ' u' , 'w.uid = u.uid' , 'LEFT')
            ->field('w.* , u.userName name, u.mobile')
            ->where($where)
            ->order('createTime DESC')
            ->select();
        $withdrawList = [];
        foreach ($withdrawArr as $k => $info){
            $withdraw = $info->getData();
            $withdraw['name'] = $withdraw['name'] ? $withdraw['name'] : '';
            $withdraw['mobile'] = $withdraw['mobile'] ? $withdraw['mobile'] : '';
            $withdraw['reason'] = $withdraw['reason'] ? $withdraw['reason'] : '';
            $withdraw['channel'] = $withdraw['channel'] == 1 ? '微信' : '支付宝';
            $withdraw['money'] = moneyConvert($withdraw['money']);
            $withdraw['balance'] = moneyConvert($withdraw['balance']);
            $withdraw['transaction'] = $withdraw['transaction'] ? $withdraw['transaction'] : '';
            if($withdraw['state'] != 1)$withdraw['updateTime'] = '';
            if($withdraw['state'] == 0){
                $withdraw['state'] = '提现中';
            }elseif ($withdraw['state'] == 1){
                $withdraw['state'] = '提现成功';
            }else{
                $withdraw['state'] = '提现失败';
            }
            $withdrawList[] = $withdraw;
        }
        outExcel($withdrawList , ['orderNum' =>"交易流水号" ,'transaction' =>"第三方流水" ,'name' =>"提现人" ,'mobile' =>"手机号" ,'createTime' =>"提现时间" ,'updateTime' =>"到账时间" ,'state' =>"提现状态" ,'channel' =>"提现方式" ,'money' =>"提现金额" ,'balance' =>"账户余额" ,'reason' =>"描述"] , '提现列表');
    }
}