<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 19:53
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use app\index\extend\jpush\JPush;
use app\index\model\OrderCommentModel;
use app\index\model\OrderComplainModel;
use think\Exception;
use think\Model;

class UserModel extends Model
{
    protected $table = 'b_user';
    protected $pk = 'uid';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'regTime';
    protected $updateTime = 'updateTime';

    protected $userAccount = 'b_user_account';
    protected $order = 'b_order';
    protected $userDetails = 'b_user_details';

    protected function base($query)
    {
        $query->where($this->table.'.isDelete' , 0);
    }

    public function today($where = []){
        //$where['createTime'] = ['egt' , date('Y-m-d')];
        return $this->where($where);
    }

    public function userIncome(){
        $state = ['0-2000' , '2000-4000' , '4000-6000' , '6000-10000', '10000以上'];
        $lists = $this->alias('u')
            ->join($this->userAccount . ' a' , 'u.uid = a.uid and a.type = 0' , 'LEFT')
            ->where('u.userType' , 0)
            ->group('u.uid')
            ->field('sum(a.money) total')
            ->select();
        $res['state'] = $state;
        $total = [0 , 0 , 0 , 0 , 0];
        foreach($lists as $k=>$v){
            $money = moneyConvert($v['total']);
            if($money < 2000){
                $total[0]++;
            }else if($money >= 2000 && $money < 4000){
                $total[1]++;
            }else if($money >= 4000 && $money < 6000){
                $total[2]++;
            }else if($money >= 6000 && $money < 10000){
                $total[3]++;
            }else{
                $total[4]++;
            }
        }
        $res['total'] = $total;
        return $res;
    }

    public function taskNum(){
        $state = ['0-20单' , '20-40单' , '40-60单' , '60-80单', '80单以上'];
        $lists = $this->alias('u')
            ->join($this->order . ' o' , 'u.uid = o.masters' , 'LEFT')
            ->where('u.userType' , 0)
            ->group('u.uid')
            ->field('count(o.oid) total')
            ->select();
        $res['state'] = $state;
        $total = [0 , 0 , 0 , 0 , 0];
        foreach($lists as $k=>$v){
            if($v['total'] < 20){
                $total[0]++;
            }else if($v['total'] >= 20 && $v['total'] < 40){
                $total[1]++;
            }else if($v['total'] >= 40 && $v['total'] < 60){
                $total[2]++;
            }else if($v['total'] >= 60 && $v['total'] < 80){
                $total[3]++;
            }else{
                $total[4]++;
            }
        }
        $res['total'] = $total;
        return $res;
    }

    public function userList($req){
        $where = [];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['u.regTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['userType']){
            switch ($req['userType']){
                case 1:
                    $where['u.userType'] = 0;
                    break;
                case 2:
                    $where['u.userType'] = 1;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'name'){
                $where['d.realName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'userName'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $userArr = $this->alias('u')->where($where)
            ->join('b_user_details d' , 'd.uid = u.uid' , 'LEFT')
            ->field('u.uid , d.realName name , u.userName , u.mobile , u.regTime , u.userType , u.remark, u.loginTime, u.appSystem, u.appVersion')
            ->order('u.regTime DESC')
            ->page($req['pageNum'] , $req['pageSize'])
            ->select();
        $total = $this->alias('u')->join('b_user_details d' , 'd.uid = u.uid' , 'LEFT')->where($where)->count();
        $userList = [];
        $pageNum = ($req['pageNum'] - 1) * $req['pageSize'];
        foreach ($userArr as $k => $info){
            $user = $info->getData();
            $user['name'] = $user['name'] ? $user['name'] : '';
            $user['userType'] = $user['userType'] == 1 ? '需求方' : '安装师傅';
            $user['rowIndex'] = ($pageNum + $k) + 1;
            $userList[] = $user;
        }
        return ['total' => $total , 'list' => $userList];
    }

    public function userExport($req){
        $where = [];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['u.regTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['userType']){
            switch ($req['userType']){
                case 1:
                    $where['u.userType'] = 0;
                    break;
                case 2:
                    $where['u.userType'] = 1;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'name'){
                $where['d.realName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'userName'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $userArr = $this->alias('u')->where($where)
            ->join('b_user_details d' , 'd.uid = u.uid' , 'LEFT')
            ->field('u.uid , d.realName name , u.userName , u.mobile , u.regTime , u.userType , u.remark')
            ->order('u.regTime DESC')
            ->select();
        $userList = [];
        foreach ($userArr as $k => $info){
            $user = $info->getData();
            $user['name'] = $user['name'] ? $user['name'] : '';
            $user['userType'] = $user['userType'] == 1 ? '需求方' : '安装师傅';
            $userList[] = $user;
        }
        outExcel($userList , ['userName' =>"账号名称" ,'mobile' =>"手机号" ,'name' =>"姓名" ,'regTime' =>"注册时间" ,'userType' =>"账号类型" ,'remark' =>"备注"] , '账号列表');
    }

    public function userDel($req){
        return $this->save(['isDelete' => 1] , ['uid' => ['in',$req['uid']]]);
    }

    public function userInfo($req){
        $field = 'u.uid , u.userName , u.mobile,u.name,u.avatar,u.userType,u.balance,u.regTime,u.remark,d.company,d.business,d.prov,d.city,d.region,d.address';
        $info = $this->alias('u')
            ->join($this->userDetails . ' d' , 'u.uid = d.uid' , 'LEFT')
            ->where(['u.uid' => $req['uid']])
            ->field($field)
            ->find();
        if(empty($info)){
            return false;
        }
        $info = $info->toArray();
        $info['balance'] = moneyConvert($info['balance']);
        $info['remark'] = $info['remark'] ? $info['remark'] : '';
        $info['company'] = $info['company'] ? $info['company'] : '';
        $info['business'] = $info['business'] ? $info['business'] : '';
        $info['prov'] = $info['prov'] ? $info['prov'] : '';
        $info['city'] = $info['city'] ? $info['city'] : '';
        $info['region'] = $info['region'] ? $info['region'] : '';
        $info['address'] = $info['address'] ? $info['address'] : '';
        if($info['userType']){
            $c = 'complainUid';
            $field = 'sum(orderState = 1) "waitRec" , sum(orderState = 0) "waitPay" , sum(orderState = 2) "rec" , sum(orderState = 3) "finish" , sum(orderState = 4) "cancel"';
            $order = (new OrderModel())->where(['uid' => $req['uid']])->field($field)->find()->toArray();
            $order['waitRec'] = (int)$order['waitRec'];
            $order['waitPay'] = (int)$order['waitPay'];
            $order['rec'] = (int)$order['rec'];
            $order['finish'] = (int)$order['finish'];
            $order['cancel'] = (int)$order['cancel'];
            $info['userTypeText']= '需求方';
            $info['order'] = $order;
        }else{
            $c = 'uid';
            $avgStar = (new OrderCommentModel())->where('masters' , $req['uid'])->avg('star');
            $field = 'sum(orderState = 2 and installState = 0) "rec" , sum(orderState = 2 and installState = 1) "finish" , sum(orderState = 4) "cancel"';
            $order = (new OrderModel())->where(['masters' => $req['uid']])->field($field)->find()->toArray();
            $order['rec'] = (int)$order['rec'];
            $order['finish'] = (int)$order['finish'];
            $order['cancel'] = (int)$order['cancel'];
            $info['order'] = $order;
            $info['userTypeText']= '安装师傅';
            $info['order']['avgStar'] = $avgStar ? round($avgStar , 1) : 0;
        }
        $info['complain'] = (new OrderComplainModel())->where([$c => $req['uid']])->count();
        return $info;
    }

    public function userEdit($req){
        $where['uid'] = $req['uid'];
        if($req['password']){
            $password = MD5($req['password']);
            $data['salt'] = getRandStr();
            $data['password'] = md5($password . $data['salt']);
        }
        $data['remark']  = $req['remark'] ? $req['remark'] : '';
        return $this->save($data , $where);
    }

    public function masterQualification($req){
        $where['u.userType'] = 0;
        $where['d.qualificationTime'] = ['exp' , 'is not null'];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['d.qualificationTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['verification']){
            switch ($req['verification']){
                case 1:
                    $where['d.verification'] = 0;
                    break;
                case 2:
                    $where['d.verification'] = 1;
                    break;
            }
        }
        if($req['qualification']){
            switch ($req['qualification']){
                case 1:
                    $where['d.qualification'] = ['in' , '0,1'];
                    break;
                case 2:
                    $where['d.qualification'] = 2;
                    break;
                case 3:
                    $where['d.qualification'] = 3;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'realName'){
                $where['d.realName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'idCard'){
                $where['d.idCard'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $userArr = $this->alias('u')
            ->join($this->userDetails . ' d' , 'd.uid = u.uid')
            ->where($where)
            ->field('u.uid , d.realName , d.idCard , u.mobile , d.qualificationTime , d.verification , d.qualification , d.qualificationReason , d.company , d.business')
            ->order('d.qualificationTime DESC')
            ->page($req['pageNum'] , $req['pageSize'])
            ->select();
        $total = $this->alias('u')->join($this->userDetails . ' d' , 'd.uid = u.uid')->where($where)->count();
        $userList = [];
        $pageNum = ($req['pageNum'] - 1) * $req['pageSize'];
        foreach ($userArr as $k => $info){
            $user = $info->getData();
            $user['realName'] = $user['realName'] ? $user['realName'] : '';
            $user['idCard'] = $user['idCard'] ? $user['idCard'] : '';
            $user['company'] = $user['company'] ? $user['company'] : '';
            $user['business'] = $user['business'] ? $user['business'] : '';
            $user['verification'] = $user['verification'] ? '已经回访' : '暂未回访';
            if($user['qualification'] == 2){
                $user['qualificationReason'] = '';
            }
            if($user['qualification'] == 2){
                $user['qualification'] = '验证成功';
            }else if($user['qualification'] == 3){
                $user['qualification'] = '验证失败';
            }else{
                $user['qualification'] = '待验证';
            }
            $user['rowIndex'] = ($pageNum + $k) + 1;
            $userList[] = $user;
        }
        return ['total' => $total , 'list' => $userList];
    }

    public function masterQualificationExport($req){
        $where['u.userType'] = 0;
        $where['d.qualificationTime'] = ['exp' , 'is not null'];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['d.qualificationTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['verification']){
            switch ($req['verification']){
                case 1:
                    $where['d.verification'] = 0;
                    break;
                case 2:
                    $where['d.verification'] = 1;
                    break;
            }
        }
        if($req['qualification']){
            switch ($req['qualification']){
                case 1:
                    $where['d.qualification'] = ['in' , '0,1'];
                    break;
                case 2:
                    $where['d.qualification'] = 1;
                    break;
                case 3:
                    $where['d.qualification'] = 2;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'realName'){
                $where['d.realName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'idCard'){
                $where['d.idCard'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $userArr = $this->alias('u')
            ->join($this->userDetails . ' d' , 'd.uid = u.uid')
            ->where($where)
            ->field('u.uid , d.realName , d.idCard , u.mobile , d.qualificationTime , d.verification , d.qualification , d.qualificationReason , d.company , d.business')
            ->order('d.qualificationTime DESC')
            ->select();
        $userList = [];
        foreach ($userArr as $k => $info){
            $user = $info->getData();
            $user['realName'] = $user['realName'] ? $user['realName'] : '';
            $user['idCard'] = $user['idCard'] ? $user['idCard'] : '';
            $user['company'] = $user['company'] ? $user['company'] : '';
            $user['business'] = $user['business'] ? $user['business'] : '';
            $user['verification'] = $user['verification'] ? '已经回访' : '暂未回访';
            if($user['qualification'] == 2){
                $user['qualificationReason'] = '';
            }
            if($user['qualification'] == 2){
                $user['qualification'] = '验证成功';
            }else if($user['qualification'] == 3){
                $user['qualification'] = '验证失败';
            }else{
                $user['qualification'] = '待验证';
            }
            $userList[] = $user;
        }
        $column = [
            'realName' =>"师傅姓名" ,
            'idCard' =>"身份证号" ,
            'mobile' =>"手机号" ,
            'qualificationTime' =>"提交时间" ,
            'verification' =>"是否回访" ,
            'qualification' =>"验证状态" ,
            'business' =>"人员类型" ,
            'company' =>"人员所属"
        ];
        outExcel($userList , $column , '安装师傅验证列表');
    }

    public function userQualification($req){
        $where['u.userType'] = 1;
        $where['d.qualificationTime'] = ['exp' , 'is not null'];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['d.qualificationTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['verification']){
            switch ($req['verification']){
                case 1:
                    $where['d.verification'] = 0;
                    break;
                case 2:
                    $where['d.verification'] = 1;
                    break;
            }
        }
        if($req['qualification']){
            switch ($req['qualification']){
                case 1:
                    $where['d.qualification'] = ['in' , '0,1'];
                    break;
                case 2:
                    $where['d.qualification'] = 2;
                    break;
                case 3:
                    $where['d.qualification'] = 3;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'company'){
                $where['d.company'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'userName'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $userArr = $this->alias('u')
            ->join($this->userDetails . ' d' , 'd.uid = u.uid')
            ->where($where)
            ->field('u.uid , u.userName , u.mobile , d.qualificationTime , d.verification , d.qualification , d.qualificationReason , d.company , d.business , d.prov , d.city , d.region , d.address')
            ->order('d.qualificationTime DESC')
            ->page($req['pageNum'] , $req['pageSize'])
            ->select();
        $total = $this->alias('u')->join($this->userDetails . ' d' , 'd.uid = u.uid')->where($where)->count();
        $userList = [];
        $pageNum = ($req['pageNum'] - 1) * $req['pageSize'];
        foreach ($userArr as $k => $info){
            $user = $info->getData();
            $user['prov'] = $user['prov'] ? $user['prov'] : '';
            $user['city'] = $user['city'] ? $user['city'] : '';
            $user['region'] = $user['region'] ? $user['region'] : '';
            $user['address'] = $user['prov'] . $user['city'] . $user['region'] . $user['address'];
            $user['company'] = $user['company'] ? $user['company'] : '';
            $user['business'] = $user['business'] ? $user['business'] : '';
            $user['verification'] = $user['verification'] ? '已经回访' : '暂未回访';
            if($user['qualification'] == 2){
                $user['qualificationReason'] = '';
            }
            if($user['qualification'] == 2){
                $user['qualification'] = '验证成功';
            }else if($user['qualification'] == 3){
                $user['qualification'] = '验证失败';
            }else{
                $user['qualification'] = '待验证';
            }
            $user['rowIndex'] = ($pageNum + $k) + 1;
            $userList[] = $user;
        }
        return ['total' => $total , 'list' => $userList];
    }

    public function userQualificationExport($req){
        $where['u.userType'] = 1;
        $where['d.qualificationTime'] = ['exp' , 'is not null'];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['d.qualificationTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['verification']){
            switch ($req['verification']){
                case 1:
                    $where['d.verification'] = 0;
                    break;
                case 2:
                    $where['d.verification'] = 1;
                    break;
            }
        }
        if($req['qualification']){
            switch ($req['qualification']){
                case 1:
                    $where['d.qualification'] = ['in' , '0,1'];
                    break;
                case 2:
                    $where['d.qualification'] = 2;
                    break;
                case 3:
                    $where['d.qualification'] = 3;
                    break;
            }
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'company'){
                $where['d.company'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'userName'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'mobile'){
                $where['u.mobile'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $userArr = $this->alias('u')
            ->join($this->userDetails . ' d' , 'd.uid = u.uid')
            ->where($where)
            ->field('u.uid , u.userName , u.mobile , d.qualificationTime , d.verification , d.qualification , d.qualificationReason , d.company , d.business , d.prov , d.city , d.region , d.address')
            ->order('d.qualificationTime DESC')
            ->select();
        $userList = [];
        foreach ($userArr as $k => $info){
            $user = $info->getData();
            $user['prov'] = $user['prov'] ? $user['prov'] : '';
            $user['city'] = $user['city'] ? $user['city'] : '';
            $user['region'] = $user['region'] ? $user['region'] : '';
            $user['address'] = $user['prov'] . $user['city'] . $user['region'] . $user['address'];
            $user['company'] = $user['company'] ? $user['company'] : '';
            $user['business'] = $user['business'] ? $user['business'] : '';
            $user['verification'] = $user['verification'] ? '已经回访' : '暂未回访';
            if($user['qualification'] == 2){
                $user['qualificationReason'] = '';
            }
            if($user['qualification'] == 2){
                $user['qualification'] = '验证成功';
            }else if($user['qualification'] == 3){
                $user['qualification'] = '验证失败';
            }else{
                $user['qualification'] = '待验证';
            }
            $userList[] = $user;
        }
        $column = [
            'company' =>"公司名称" ,
            'userName' =>"用户名" ,
            'mobile' =>"手机号" ,
            'qualificationTime' =>"提交时间" ,
            'verification' =>"是否回访" ,
            'qualification' =>"验证状态" ,
            'business' =>"经营业务" ,
            'address' =>"公司地址"
        ];
        outExcel($userList , $column , '需求端验证列表');
    }

    public function qualificationInfo($req){
        $where['u.uid'] = $req['uid'];
        $userInfo = $this->alias('u')
            ->join($this->userDetails . ' d' , 'd.uid = u.uid')
            ->where($where)
            ->field('u.remark , u.mobile , u.userName , d.*')
            ->find();
        if(empty($userInfo)){
            return false;
        }
        $userInfo = $userInfo->toArray();
        $userInfo['realName'] = $userInfo['realName'] ? $userInfo['realName'] : '';
        $userInfo['idCard'] = $userInfo['idCard'] ? $userInfo['idCard'] : '';
        $userInfo['company'] = $userInfo['company'] ? $userInfo['company'] : '';
        $userInfo['business'] = $userInfo['business'] ? $userInfo['business'] : '';
        $userInfo['remark'] = $userInfo['remark'] ? $userInfo['remark'] : '';
        $userInfo['qualificationReason'] = $userInfo['qualificationReason'] ? $userInfo['qualificationReason'] : '';
        return $userInfo;
    }

    public function qualificationEdit($req){
        $where['uid'] = $req['uid'];
        $userInfo = $this->where($where)->field('userType , token')->find();
        if(empty($userInfo))return false;
        $userDetailsModel = new UserDetailsModel();
        $data['verification'] = (int)$req['verification'];
        $data['qualification'] = (int)$req['qualification'];
        $data['qualificationReason'] = $req['qualificationReason'];
        $data['company'] = $req['company'];
        if($data['qualification'] == 2){
            $data['qualificationReason'] = NULL;
        }
        if($userInfo['userType'] == 0){
            $data['idCard'] = $req['idCard'];
            $data['realName'] = $req['realName'];
            $data['business'] = $req['business'];
        }
        if($req['remark'])$remark = $req['remark'];
        try{
            if($data['qualification'] > 1){
                $userDetails = $userDetailsModel->where($where)->field('qualification')->find();
                if(!empty($userDetails) && $data['qualification'] != $userDetails['qualification']){
                    $pushObj = new JPush();
                    if($data['qualification'] == 2){
                        $title = '您的资质验证已经通过审核';
                        $notifyType = 9;
                    }elseif ($data['qualification'] == 3){
                        $title = '您的资质验证未通过审核';
                        $notifyType = 10;
                        if($data['qualificationReason']){
                            $title .=',原因：' . $data['qualificationReason'];
                        }
                    }
                    $pushObj->pushAlias(['alias_' . $userInfo['token']] , $title , ['oid' => 0 , 'notifyType' => $notifyType , 'notifyMsg' => '资质审核']);
                }
            }
            $userDetailsModel->save($data , $where);
            if(isset($remark)){
                (new UserModel())->save(['remark' => $remark] , $where);
            }
        }catch (Exception $e){
            return false;
        }
        return true;
    }

    public function qualificationDel($req){
        $where['uid'] = ['in',$req['uid']];
        return (new UserDetailsModel())->where($where)->delete();
    }

    public function mastersList()
    {
        $where['u.userType'] = 0;
        $where['d.qualification'] = 2;
        $res = $this->alias('u')
                    ->join($this->userDetails . ' d' , 'd.uid = u.uid')
                    ->where($where)
                    ->field('u.uid, u.mobile, u.userName, d.realName')
                    ->select();
        return $res;
    }
}