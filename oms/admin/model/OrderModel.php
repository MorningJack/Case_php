<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 18:20
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use app\index\extend\HttpClient;
use app\index\model\OrderCommentModel;
use app\index\model\OrderDetailsModel;
use think\Config;
use think\Model;

class OrderModel extends Model
{
    protected $table = 'b_order';
    protected $pk = 'oid';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';

    protected $userModel = 'b_user';
    protected $orderInstallModel = 'b_order_install';
    protected $orderDetailsModel = 'b_order_details';

    protected function base($query)
    {
        $query->where($this->table.'.isDelete' , 0);
    }

    public function today(){
        $where['createTime'] = ['egt' , date('Y-m-d')];
        return $this->where($where);
    }

    public function orderState(){
        $state = ['待接单' , '待支付' , '已接单' , '已结束' , '已取消'];
        $field = 'sum(orderState = 1) "a" , sum(orderState = 0) "b" , sum(orderState = 2) "c" , sum(orderState = 3) "d" , sum(orderState = 4) "e"';
        $lists = $this->field($field)->find()->toArray();
        $res['state'] = $state;
        $res['total'] = [$lists['a'] , $lists['b'] , $lists['c'] , $lists['d'] , $lists['e']];
        return $res;
    }


    public function orderMoney(){
        $state = ['60以下' , '60-80' , '80-100' , '100-120' , '120以上'];
        $field = 'sum(reward < 6000) "a" , sum(reward >= 6000 and reward < 8000) "b" , sum(reward >= 8000 and reward < 10000) "c" , sum(reward >= 10000 and reward < 12000) "d" , sum(reward >= 12000) "e"';
        $lists = $this->field($field)->find()->toArray();
        $res['state'] = $state;
        $res['total'] = [$lists['a'] , $lists['b'] , $lists['c'] , $lists['d'] , $lists['e']];
        return $res;
    }

    public function orderList($req){
        $where = [];
        if($req['orderType']){
            switch ($req['orderType']){
                case 1:
                    $where['o.orderState'] = 1;
                    break;
                case 2:
                    $where['o.orderState'] = 0;
                    break;
                case 3:
                    $where['o.orderState'] = 2;
                    $where['o.installState'] = 0;
                    break;
                case 4:
                    $where['o.orderState'] = 2;
                    $where['o.installState'] = 1;
                    break;
                case 5:
                    $where['o.orderState'] = 3;
                    break;
                case 6:
                    $where['o.orderState'] = 4;
                    break;
            }
        }
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['o.createTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'user'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'masters'){
                $where['m.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'title'){
                $where['o.title'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'orderNum'){
                $where['o.orderNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $orderArr = $this->where($where)->alias('o')
            ->join($this->userModel . ' u' , 'u.uid = o.uid')
            ->join($this->userModel . ' m' , 'm.uid = o.masters' , 'LEFT')
            ->join($this->orderInstallModel . ' i' , 'i.oid = o.oid' , 'LEFT')
            ->join($this->orderDetailsModel . ' d', 'd.oid = o.oid', 'LEFT')
            ->field('o.oid , o.orderNum , o.title , o.taskTime , u.userName name , u.mobile, o.uid ,
            m.userName mastersName , m.mobile mastersMobile, o.masters , o.reward ,o.orderState , o.installState , o.createTime,o.remark,
            i.plateNum, i.shelfCode, i.carOwner, i.carType, i.oiid, d.id did')
            ->order('o.createTime DESC')
            ->page($req['pageNum'] , $req['pageSize'])
            ->select();
        $total = $this->where($where)->alias('o')
            ->join($this->userModel . ' u' , 'u.uid = o.uid')
            ->join($this->userModel . ' m' , 'm.uid = o.masters' , 'LEFT')
            ->join($this->orderInstallModel . ' i' , 'i.oid = o.oid' , 'LEFT')
            ->join($this->orderDetailsModel . ' d', 'd.oid = o.oid', 'LEFT')
            ->count();
        $orderList = [];
        $pageNum = ($req['pageNum'] - 1) * $req['pageSize'];
        foreach ($orderArr as $k => $info){
            $order = $info->getData();
            $order['reward'] = moneyConvert($order['reward']);
            $order['name'] = $order['name'] ?  $order['name']  : '';
            $order['remark'] = $order['remark'] ? $order['remark'] : '';
            $order['mastersName'] = $order['mastersName'] ?  $order['mastersName']  : '';
            $order['mastersMobile'] = $order['mastersMobile'] ? $order['mastersMobile'] : '';
            if($order['orderState'] == 0){
                $order['orderState'] = '待支付';
            }elseif ($order['orderState'] == 1){
                $order['orderState'] = '待接单';
            }elseif ($order['orderState'] == 2 && $order['installState'] == 0){
                $order['orderState'] = '待安装';
            }elseif ($order['orderState'] == 2 && $order['installState'] == 1){
                $order['orderState'] = '已完成';
            }elseif ($order['orderState'] == 3){
                $order['orderState'] = '已结束';
            }elseif ($order['orderState'] == 4){
                $order['orderState'] = '已取消';
            }else{
                $order['orderState'] = '';
            }
            $order['rowIndex'] = ($pageNum + $k) + 1;
            $orderList[] = $order;
        }
        return ['total' => $total , 'list' => $orderList];
    }

    public function orderExport($req){
        $where = [];
        if($req['orderType']){
            switch ($req['orderType']){
                case 1:
                    $where['o.orderState'] = 1;
                    break;
                case 2:
                    $where['o.orderState'] = 0;
                    break;
                case 3:
                    $where['o.orderState'] = 2;
                    $where['o.installState'] = 0;
                    break;
                case 4:
                    $where['o.orderState'] = 2;
                    $where['o.installState'] = 1;
                    break;
                case 5:
                    $where['o.orderState'] = 3;
                    break;
                case 6:
                    $where['o.orderState'] = 4;
                    break;
            }
        }
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['o.createTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'user'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'masters'){
                $where['m.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'title'){
                $where['o.title'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'orderNum'){
                $where['o.orderNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $orderArr = $this->where($where)->alias('o')
            ->join($this->userModel . ' u' , 'u.uid = o.uid')
            ->join($this->userModel . ' m' , 'm.uid = o.masters' , 'LEFT')
            ->field('o.oid , o.orderNum , o.title , o.taskTime , u.userName name , u.mobile , m.userName mastersName , m.mobile mastersMobile , o.reward ,o.orderState , o.installState , o.createTime,o.remark')
            ->order('o.createTime DESC')
            ->select();
        $orderList = [];
        foreach ($orderArr as $k => $info){
            $order = $info->getData();
            $order['reward'] = moneyConvert($order['reward']);
            $order['name'] = $order['name'] ? $order['name'] : '';
            $order['remark'] = $order['remark'] ? $order['remark'] : '';
            $order['mastersName'] = $order['mastersName'] ? $order['mastersName'] : '';
            $order['mastersMobile'] = $order['mastersMobile'] ? $order['mastersMobile'] : '';
            if($order['orderState'] == 0){
                $order['orderState'] = '待支付';
            }elseif ($order['orderState'] == 1){
                $order['orderState'] = '待接单';
            }elseif ($order['orderState'] == 2 && $order['installState'] == 0){
                $order['orderState'] = '待安装';
            }elseif ($order['orderState'] == 2 && $order['installState'] == 1){
                $order['orderState'] = '已完成';
            }elseif ($order['orderState'] == 3){
                $order['orderState'] = '已结束';
            }elseif ($order['orderState'] == 4){
                $order['orderState'] = '已取消';
            }else{
                $order['orderState'] = '';
            }
            $orderList[] = $order;
        }
        $column = [
            'orderNum' =>"订单名称" ,
            'title' =>"订单号" ,
            'createTime' =>"创建时间" ,
            'name' =>"创建人" ,
            'mobile' =>"手机号" ,
            'orderState' =>"订单状态" ,
            'reward' =>"报酬(元)" ,
            'mastersName' =>"接单人" ,
            'mastersMobile' =>"手机号" ,
            'remark' =>"备注"
        ];
        outExcel($orderList , $column , '订单列表');
    }

    public function orderDel($req){
        return $this->where(['oid'=>['in',$req['oid']]])->update(['isDelete'=>1]);
    }

    public function orderUpdateInfo($req)
    {
        $where['oid'] = $req['oid'];
        $field = 'oid, uid, masters, orderNum, title, taskTime, prov, city, region, address, contacts, mobile, lat, lng, reward, remark, orderState, installState, createTime';
        $orderInfo = $this->where($where)->field($field)->find();
        if(empty($orderInfo)){
            return false;
        }
        $user = (new \app\index\model\UserModel())->getFieldByWhere(['uid' => $orderInfo['uid']] , 'userName name, mobile');
        if(empty($user)){
            return false;
        }
        $orderInfo = $orderInfo->toArray();
        $orderInfo['name'] = $user['name'];
        $orderInfo['mobile'] = $orderInfo['mobile'];
        $orderInfo['remark'] = $orderInfo['remark'] ? $orderInfo['remark'] : "";
        if($orderInfo['orderState'] == 0){
            $orderInfo['orderState'] = '待支付';
        }elseif ($orderInfo['orderState'] == 1){
            $orderInfo['orderState'] = '待接单';
        }elseif ($orderInfo['orderState'] == 2 && $orderInfo['installState'] == 0){
            $orderInfo['orderState'] = '待安装';
        }elseif ($orderInfo['orderState'] == 2 && $orderInfo['installState'] == 1){
            $orderInfo['orderState'] = '已完成';
        }elseif ($orderInfo['orderState'] == 3){
            $orderInfo['orderState'] = '已结束';
        }elseif ($orderInfo['orderState'] == 4){
            $orderInfo['orderState'] = '已取消';
        }else{
            $orderInfo['orderState'] = '';
        }
        $orderInfo['reward'] = moneyConvert($orderInfo['reward']);
        $where['id'] = $req['did'];
        $details = (new OrderDetailsModel())->where($where)->field('id did, brand, wired, wireless')->find();
        if(!empty($details)){
            $details = $details->getData();
            $orderInfo['did'] = $details['did'];
            $orderInfo['brand'] = is_numeric($details['brand'])?(int)$details['brand']:$details['brand'];
            $orderInfo['wired'] = $details['wired'];
            $orderInfo['wireless'] = $details['wireless'];
        }else{
            $orderInfo['did'] = 0;
            $orderInfo['brand'] = '';
            $orderInfo['wired'] = 0;
            $orderInfo['wireless'] = 0;
        }
        unset($where['id']);
        $where['oiid'] = $req['oiid'];
        $install = (new OrderInstallModel())->where($where)->field('oiid, plateNum, shelfCode, engineCode, carOwner')->find();
        if(!empty($install)){
            $install = $install->getData();
            $orderInfo['oiid'] = $install['oiid'];
            $orderInfo['plateNum'] = $install['plateNum'];
            $orderInfo['shelfCode'] = $install['shelfCode'];
            $orderInfo['engineCode'] = $install['engineCode'];
            $orderInfo['carOwner'] = $install['carOwner'];
        }else{
            $orderInfo['oiid'] = 0;
            $orderInfo['plateNum'] = '';
            $orderInfo['shelfCode'] = '';
            $orderInfo['engineCode'] = '';
            $orderInfo['carOwner'] = '';
        }
        return $orderInfo;
    }

    public function orderInfo($req){
        $where['oid'] = $req['oid'];
        $field = 'oid ,uid , masters , orderNum , title , taskTime , prov , city , region , address , contacts , mobile , lat , lng , reward , remark , orderState , installState , commentState';
        $orderInfo = $this->where($where)->field($field)->find();
        if(empty($orderInfo)){
            return false;
        }
        $user = (new \app\index\model\UserModel())->getFieldByWhere(['uid' => $orderInfo['uid']] , 'userName name');
        if(empty($user)){
            return false;
        }
        $orderInfo = $orderInfo->toArray();
        $orderInfo['name'] = $user['name'];
        $orderInfo['remark'] = $orderInfo['remark'] ? $orderInfo['remark'] : "";
        if($orderInfo['orderState'] == 0){
            $orderInfo['orderState'] = '待支付';
        }elseif ($orderInfo['orderState'] == 1){
            $orderInfo['orderState'] = '待接单';
        }elseif ($orderInfo['orderState'] == 2 && $orderInfo['installState'] == 0){
            $orderInfo['orderState'] = '待安装';
        }elseif ($orderInfo['orderState'] == 2 && $orderInfo['installState'] == 1){
            $orderInfo['orderState'] = '已完成';
        }elseif ($orderInfo['orderState'] == 3){
            $orderInfo['orderState'] = '已结束';
        }elseif ($orderInfo['orderState'] == 4){
            $orderInfo['orderState'] = '已取消';
        }else{
            $orderInfo['orderState'] = '';
        }
        $orderInfo['reward'] = moneyConvert($orderInfo['reward']);
        $details = (new OrderDetailsModel())->where('oid' , $orderInfo['oid'])->field('oid' , true)->select();
        $orderInfo['details'] = [];
        foreach($details as $item){
            $orderInfo['details'][] = $item->getData();
        }
        $orderInfo['mastersInfo'] = [];
        if($orderInfo['masters']){
            $masters = (new \app\index\model\UserModel())->getFieldByWhere(['uid' => $orderInfo['masters']] , 'mobile , avatar , userName name , lat , lng');
            if(!empty($masters)){
                $masters = $masters->toArray();
                $masters['avgStar'] = (new OrderCommentModel())->where('masters' , $orderInfo['masters'])->avg('star');
                $masters['avgStar'] = $masters['avgStar'] ? round($masters['avgStar'] , 1) : 0;
                $orderTotal = $this->where('masters' , $orderInfo['masters'])->field('sum(orderState = 3) finishNum , sum(orderState = 4) cancelNum')->find();
                $masters['finishNum'] = (int)$orderTotal['finishNum'];
                $masters['cancelNum'] = (int)$orderTotal['cancelNum'];
                $masters['avatar'] = $masters['avatar'] ? $masters['avatar'] : "";
                $masters['name'] = $masters['name'] ? $masters['name'] : "";
                $masters['lat'] = $masters['lat'] ? $masters['lat'] : 0;
                $masters['lng'] = $masters['lng'] ? $masters['lng'] : 0;
                $orderInfo['mastersInfo'][] = $masters;
            }
        }
        $orderInfo['comment'] = [];
        if($orderInfo['commentState']){
            $comment = (new OrderCommentModel())->where('oid' , $orderInfo['oid'])->field('star , images , comment')->order("createTime asc")->find();
            if(!empty($comment)){
                $comment = $comment->toArray();
                $comment['images'] = $comment['images'] ? explode(',' , $comment['images']) : [];
                $orderInfo['comment'][] = $comment;
            }
        }
        return $orderInfo;
    }

    public function addOrder($req)
    {
        $data['orderNum'] = 'M' . date('YmdHis') . rand(100 , 999) . rand(10 , 99);
        $data['uid'] = Config::get('mapgoo_user');
        $data['masters'] = $req['masters'];
        $data['title'] = $data['orderNum'];
        $data['taskTime'] = $req['taskTime'];
        $data['prov'] = $req['prov'];
        $data['city'] = $req['city'];
        $data['region'] = $req['region'];
        $data['address'] = $req['address'];
        $data['contacts'] = $req['contacts'];
        $data['mobile'] = $req['mobile'];
        $data['lat'] = $req['lat'];
        $data['lng'] = $req['lng'];
        $data['reward'] = $req['reward'] * 100;
        $data['remark'] = $req['remark'];
        $data['orderType'] = 1;
        $data['designateNum'] = 1;
        $data['orderState'] = 2;
        $data['payType'] = -1;
        $data['createTime'] = date('Y-m-d H:i:s');
        $data['updateTime'] = $data['recTime'] = $data['payTime'] = $data['createTime'];
        try{
            $this->startTrans();
            $o = $this->create($data);
            $save['oid'] = $o->oid;
            $save['uid'] = $data['masters'];
            $details['oid'] = $o->oid;
            $details['brand'] = $req['brand'];
            $details['wired'] = $req['wired'];
            $details['wireless'] = $req['wireless'];
            $install['oiid'] = $o->oid . '0';
            $install['oid'] = $o->oid;
            $install['plateNum'] = $req['plateNum'];
            $install['shelfCode'] = $req['shelfCode'];
            $install['engineCode'] = $req['engineCode'];
            $install['carOwner'] = $req['carOwner'];
            $install['carType'] = $req['brand'];
            $data['oid'] = $o->oid;
            (new OrderDesignatedModel())->create($save);
            (new OrderDetailsModel())->create($details);
            (new OrderInstallModel())->create($install);
            $this->commit();
        }catch (Exception $e){
            Log::sql('AddOrder Error : '.$e->getMessage());
            $this->rollback();
            return false;
        }
        (new \app\index\model\UserModel())->pushOrder($data);
        return true;
    }

    public function updateOrder($req)
    {
        $state = ['已完成', '已结束', '已取消'];
        if(!in_array($req['orderState'], $state)){
            $data['masters'] = $req['masters'];
        }
        $data['title'] = $req['title'];
        $data['mobile'] = $req['mobile'];
        $data['prov'] = $req['prov'];
        $data['city'] = $req['city'];
        $data['region'] = $req['region'];
        $data['address'] = $req['address'];
        $data['lat'] = $req['lat'];
        $data['lng'] = $req['lng'];
        $data['remark'] = $req['remark'];
        $data['orderType'] = 1;
        $data['designateNum'] = 1;
        $data['payType'] = -1;
        $data['updateTime'] = date('Y-m-d H:i:s');
        $orderDesignatedModel = new OrderDesignatedModel();
        try{
            $this->startTrans();
            $this->save($data, ['oid' => $req['oid']]);
            if(isset($data['masters'])){
                $orderDesignatedModel->where('oid' , $req['oid'])->delete();
                $save['oid'] = $req['oid'];
                $save['uid'] = $data['masters'];
                $orderDesignatedModel->create($save);
            }
            $details['brand'] = $req['brand'];
            $details['wired'] = $req['wired'];
            $details['wireless'] = $req['wireless'];

            $install['plateNum'] = $req['plateNum'];
            $install['shelfCode'] = $req['shelfCode'];
            $install['engineCode'] = $req['engineCode'];
            $install['carOwner'] = $req['carOwner'];
            $install['carType'] = $req['brand'];
            (new OrderDetailsModel())->save($details, ['id' => $req['did']]);
            if($req['oiid']){
                (new OrderInstallModel())->save($install, ['oiid' => $req['oiid'], 'oid' => $req['oid']]);
            }else{
                $install['oiid'] = $req['oid'] . '0';
                $install['oid'] = $req['oid'];
                (new OrderInstallModel())->create($install);
            }
            $this->commit();
        }catch (Exception $e){
            Log::sql('UpdateOrder Error : '.$e->getMessage());
            $this->rollback();
            return false;
        }
        return true;
    }

    public function importOrder($excel)
    {
        \think\Loader::import('PHPExcel.PHPExcel', EXTEND_PATH);
        \think\Loader::import('PHPExcel.Reader.IOFactory', EXTEND_PATH);
        $aryStr = explode(".", $excel);
        $fileType = strtolower($aryStr[count($aryStr)-1]);
        if($fileType == 'xlsx'){
            \think\Loader::import('PHPExcel.Reader.Excel2007', EXTEND_PATH);
            $objReader = new \PHPExcel_Reader_Excel2007();
        }else if($fileType == 'xls'){
            \think\Loader::import('PHPExcel.Reader.Excel5', EXTEND_PATH);
            $objReader = new \PHPExcel_Reader_Excel5();
        }
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($excel);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        if($highestRow > 1000)ajax_info(1, "一次最多导入1000行");
        if($highestColumn != "N")ajax_info(1, "模板有误");
        $data = $objPHPExcel->getActiveSheet()->toArray();
        $url = Config::get('baidu_map_url');
        $http = new HttpClient();

        unset($data[0]);
        unset($data[1]);
        unset($data[2]);
        $mastersList = (new UserModel())->mastersList();
        $mastersIds = [];
        foreach($mastersList as $key => $value){
            $mastersIds[$value['mobile']] = $value['uid'];
            unset($mastersList[$key]);
        }
        $j = 0;
        $i = 0;
        $now = date('Y-m-d H:i:s');
        $orderDesignatedModel = new OrderDesignatedModel();
        $orderDetailsModel = new OrderDetailsModel();
        $orderInstallModel = new OrderInstallModel();
        $userMobel = new \app\index\model\UserModel();
        $error = [];
        foreach ($data as $k=>$v){
            if(!$data[$k][0] && !$data[$k][1] && !$data[$k][2] && !$data[$k][3] && !$data[$k][4] &&
                !$data[$k][5] && !$data[$k][6] && !$data[$k][7] && !$data[$k][8] && !$data[$k][9] &&
                !$data[$k][10] && !$data[$k][11] && !$data[$k][12] && !$data[$k][13])continue;
            $add = [];
            $address = sprintf($url, 'address', $data[$k][12]);
            $rep = $http->Request($address);
            $rep = json_decode($rep, true);
            if($rep && $rep['status'] == 0){
                if(isset($rep['result']['location']['lat']) && isset($rep['result']['location']['lng'])){
                    $location = sprintf($url, 'location', $rep['result']['location']['lat'] . ',' . $rep['result']['location']['lng']);
                    $rep = $http->Request($location);
                    $rep = json_decode($rep, true);
                    if($rep && $rep['status'] == 0 && isset($rep['result']['location']['lat']) && isset($rep['result']['location']['lng']) && isset($rep['result']['addressComponent'])){
                        $add['prov'] = $rep['result']['addressComponent']['province'] ? $rep['result']['addressComponent']['province'] : '';
                        $add['city'] = $rep['result']['addressComponent']['city'] ? $rep['result']['addressComponent']['city'] : '';
                        $add['region'] = $rep['result']['addressComponent']['district'] ? $rep['result']['addressComponent']['district'] : '';
                        $add['address'] = str_replace([$add['prov'], $add['city'], $add['region']], "", $data[$k][12]);
                        $add['lat'] = $rep['result']['location']['lat'];
                        $add['lng'] = $rep['result']['location']['lng'];
                    }
                }
            }
            if(!isset($add['prov'])){
                $error[] = "第".$k."行,第十二列地址无法解析";
                $i++;
                continue;
            }
            $add['orderNum'] = 'M' . date('YmdHis') . rand(100 , 999) . rand(10 , 99);
            $add['uid'] = Config::get('mapgoo_user');
            $add['masters'] = isset($mastersIds[(string)$data[$k][8]]) ? $mastersIds[(string)$data[$k][8]] : 0;
            if(!$add['masters']){
                $error[] = "第".$k."行,第八列指派手机号码未注册或者未认证";
                $i++;
                continue;
            }
            $add['title'] = $add['orderNum'];
            $add['taskTime'] = date('Y-m-d H:i:s', strtotime($data[$k][5]));
            if(!$add['taskTime']){
                $error[] = "第".$k."行,第五列时间有误";
                $i++;
                continue;
            }
            $add['contacts'] = $data[$k][10];
            if(!$add['contacts']){
                $error[] = "第".$k."行,第十列联系人不能为空";
                $i++;
                continue;
            }
            $add['mobile'] = $data[$k][11];
            if(!$add['mobile']){
                $error[] = "第".$k."行,第十一列联系电话不能为空";
                $i++;
                continue;
            }
            $add['reward'] = $data[$k][9] * 100;
            if(!$add['reward']){
                $error[] = "第".$k."行,第九列任务报酬不能为空";
                $i++;
                continue;
            }
            $add['remark'] = $data[$k][13];
            if(!$data[$k][4]){
                $error[] = "第".$k."行,第四列品牌不能为空";
                $i++;
                continue;
            }
            if(!$data[$k][6] && !$data[$k][7]){
                $error[] = "第".$k."行,第六列安装设备不能为空";
                $i++;
                continue;
            }
            $add['orderType'] = 1;
            $add['designateNum'] = 1;
            $add['orderState'] = 2;
            $add['payType'] = -1;
            $add['updateTime'] = $add['recTime'] = $add['payTime'] = $add['createTime'] = $now;
            try{
                $this->startTrans();
                $o = $this->create($add);
                $save['oid'] = $o->oid;
                $save['uid'] = $add['masters'];
                $details['oid'] = $o->oid;
                $details['brand'] = $data[$k][4];
                $details['wired'] = (int)$data[$k][6];
                $details['wireless'] = (int)$data[$k][7];
                $install['oiid'] = $o->oid . '0';
                $install['oid'] = $o->oid;
                $install['plateNum'] = $data[$k][0] ? $data[$k][0] : '';
                $install['shelfCode'] = $data[$k][2] ? $data[$k][2] : '';
                $install['engineCode'] = $data[$k][3] ? $data[$k][3] : '';
                $install['carOwner'] = $data[$k][1] ? $data[$k][1] : '';
                $install['carOwner'] = $data[$k][4];
                $add['oid'] = $o->oid;
                $orderDesignatedModel->create($save);
                $orderDetailsModel->create($details);
                $orderInstallModel->create($install);
                $this->commit();
            }catch (Exception $e){
                Log::sql('ImportOrder Error : '.$e->getMessage());
                $this->rollback();
                $error[] = "sqlError:" . $e->getMessage();
                $i++;
                continue;
            }
            $userMobel->pushOrder($add);
            $j++;
        }
        $import['xlsPath'] = $excel;
        $import['successNum'] = $j;
        $import['errorNum'] = $i;
        $import['errorContent'] = serialize($error);
        $import['createTime'] = $now;
        try {
            (new OrderImportLogModel())->create($import);
            $res['num'] = $import['successNum'] + $import['errorNum'];
            $res['successNum'] = $import['successNum'];
            $res['errorNum'] = $import['errorNum'];
            return $res;
        }catch (Exception $e){
            Log::sql('ImportInstall Error : '.$e->getMessage());
            return false;
        }
    }
}