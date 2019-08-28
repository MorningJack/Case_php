<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/3 9:38
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use think\Exception;
use think\Model;

class OrderInstallModel extends Model
{
    protected $table = 'b_order_install';
    protected $pk = 'oiid';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'createTime';
    protected $updateTime = '';

    protected $userModel = 'b_user';
    protected $orderModel = 'b_order';
    protected $deviceModel = 'b_order_install_device';

    public function installList($req){
        $where = [];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['i.createTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'user'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'masters'){
                $where['m.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'plateNum'){
                $where['i.plateNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'orderNum'){
                $where['o.orderNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $where['o.installState'] = 1;
        $installArr = $this->alias('i')
                    ->join($this->orderModel . ' o' , 'o.oid = i.oid' , 'LEFT')
                    ->join($this->userModel . ' u' , 'u.uid = o.uid' , 'LEFT')
                    ->join($this->userModel . ' m' , 'm.uid = o.masters')
                    ->field('i.oiid, i.plateNum, i.createTime, o.orderNum, o.taskTime, u.userName name, m.userName mastersName, 
                    o.createTime orderTime, o.reward, i.shelfCode, i.carType, i.operation, CONCAT(o.city, o.region) installRegion, 
                    (select GROUP_CONCAT(isWireless) from ' . $this->deviceModel . ' d where d.oiid = i.oiid and isWireless is not null) deviceNum')
                    ->where($where)
                    ->order('i.createTime DESC')
                    ->page($req['pageNum'] , $req['pageSize'])
                    ->select();
            $total  = $this->alias('i')
                    ->join($this->orderModel . ' o' , 'o.oid = i.oid' , 'LEFT')
                    ->join($this->userModel . ' u' , 'u.uid = o.uid' , 'LEFT')
                    ->join($this->userModel . ' m' , 'm.uid = o.masters')
                    ->where($where)
                    ->count();
        $installList = [];
        $pageNum = ($req['pageNum'] - 1) * $req['pageSize'];
        $operation = ['新装'];
        $deviceType = ['有线', '无线'];
        foreach ($installArr as $k => $info){
            $install = $info->getData();
            $install['name'] = $install['name'] ? $install['name'] : '';
            $install['mastersName'] = $install['mastersName'] ? $install['mastersName'] : '';
            $device = $install['deviceNum'] ? explode(',', $install['deviceNum']) : '';
            if($device){
                $str = [];
                $device = array_count_values($device);
                foreach ($deviceType as $key => $value){
                    if(isset($device[$key]))$str[] = $deviceType[$key] . '*' . $device[$key];
                }
                $device = implode(',', $str);
            }
            $install['deviceNum'] = $device;
            $install['operation'] = $operation[$install['operation']];
            $install['reward']  = moneyConvert($install['reward']);
            $install['rowIndex'] = ($pageNum + $k) + 1;
            $installList[] = $install;
        }
        return ['total' => $total , 'list' => $installList];
    }

    public function installTotal($req)
    {
        $where = [];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['i.createTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'user'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'masters'){
                $where['m.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'plateNum'){
                $where['i.plateNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'orderNum'){
                $where['o.orderNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        $installArr = $this->alias('i')
            ->join($this->orderModel . ' o' , 'o.oid = i.oid' , 'LEFT')
            ->join($this->userModel . ' u' , 'u.uid = o.uid' , 'LEFT')
            ->join($this->userModel . ' m' , 'm.uid = o.masters')
            ->join($this->deviceModel . ' d' , 'd.oiid = i.oiid')
            ->field('count(DISTINCT o.oid) orderNum, count(DISTINCT i.oiid) carNum, sum(isWireless = 0) wired, sum(isWireless = 1) wireless')
            ->where($where)
            ->find();

        $sql = $this->alias('i')
            ->join($this->orderModel . ' o' , 'o.oid = i.oid' , 'LEFT')
            ->join($this->userModel . ' u' , 'u.uid = o.uid' , 'LEFT')
            ->join($this->userModel . ' m' , 'm.uid = o.masters')
            ->field('DISTINCT o.oid')
            ->where($where)
            ->buildSql();
        $reward = (new OrderModel())->where(array('oid' => ['exp', 'in ' . $sql]))->sum('reward');
        $installArr['orderNum'] = (int)$installArr['orderNum'];
        $installArr['carNum'] = (int)$installArr['carNum'];
        $installArr['wired'] = (int)$installArr['wired'];
        $installArr['wireless'] = (int)$installArr['wireless'];
        $installArr['reward'] = moneyConvert($reward);
        return $installArr;
    }

    public function installExport($req){
        $where = [];
        if(($req['startTime'] && $req['endTime']) || $req['dateNumber']){
            dateDiff($req['startTime'], $req['endTime'], $req['dateNumber']);
            $where['i.createTime'] = ['between' , [date('Y-m-d', strtotime($req['startTime'])), date('Y-m-d H:i:s', strtotime('+1 day', strtotime($req['endTime'])) - 1)]];
        }
        if($req['searchKey'] && $req['searchValue']){
            if($req['searchKey'] == 'user'){
                $where['u.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'masters'){
                $where['m.userName'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'plateNum'){
                $where['i.plateNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }elseif($req['searchKey'] == 'orderNum'){
                $where['o.orderNum'] = ['like' , '%' . $req['searchValue'] . '%'];
            }
        }
        if($req['oiid']){
            $where['i.oiid'] = ['in', explode(',' , $req['oiid'])];
        }
        $installArr = $this->alias('i')
            ->join($this->orderModel . ' o' , 'o.oid = i.oid' , 'LEFT')
            ->join($this->userModel . ' u' , 'u.uid = o.uid' , 'LEFT')
            ->join($this->userModel . ' m' , 'm.uid = o.masters')
            ->join($this->deviceModel . ' d' , 'd.oiid = i.oiid')
            ->field('i.oiid, i.plateNum, i.createTime, o.taskTime, m.userName mastersName, 
                    o.createTime orderTime, i.shelfCode, i.carType, i.operation, CONCAT(o.city, o.region) installRegion, d.imei, d.deviceType, d.isWireless, d.images, d.position')
            ->where($where)
            ->order('i.createTime DESC')
            ->select();
        $installList = [];
        $operation = ['新装'];
        foreach ($installArr as $k => $info){
            $install = $info->getData();
            $device[$install['oiid']][] = [
                'imei'        =>  $install['imei'],
                'deviceType'  =>  $install['deviceType'],
                'isWireless'  =>  $install['isWireless'] === 1 ? '无线' : ($install['isWireless'] === 0 ? '有线' : '未知'),
                'images'      =>  $install['images'],
                'position'    =>  $install['position']
            ];
            $install['mastersName'] = $install['mastersName'] ? $install['mastersName'] : '';
            $install['operation'] = $operation[$install['operation']];
            $install['device'] = $device[$install['oiid']];
            $installList[$info['oiid']] = $install;
        }
        $column = [
            "编号",
            "下单时间",
            "安装师傅",
            "作业类型",
            "车架号",
            "车牌",
            "车型",
            "作业区域",
            "任务时间",
            "安装时间",
            "设备数量",
            "设备类型",
            "设备型号",
            "设备编号",
            "安装位置"
        ];
        $title = '麦谷安装明细汇总';

        \think\Loader::import('PHPExcel.PHPExcel', EXTEND_PATH);
        $PHPExcel = new \PHPExcel();
        $fileName = $xlsTitle = $title ? $title : date('Y-m-d H:i:s');

        $PHPExcel->setActiveSheetIndex(0);
        $activeSheet = $PHPExcel->getActiveSheet();
        $activeSheet->mergeCells('A1:O1');
        $activeSheet->setCellValue('A1', $fileName);
        $activeSheet->getStyle('A1')->applyFromArray(
            array(
                'font' => array (
                    'bold' => true
                ),
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            )
        );

        $c = 'A';
        foreach ($column as $key => $value){
            $activeSheet->setCellValue($c . '2', $value);
            $activeSheet->getColumnDimension($c)->setWidth(20);
            $activeSheet->getStyle($c . '2')->applyFromArray(
                array(
                    'font' => array (
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                )
            );
            $c++;
        }
        $column = 3;
        $font = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        $n = 1;
        foreach ($installList as $k => $value){
            $num = count($value['device']);
            $next = ($column + $num) - 1;
            if($num > 1){
                $activeSheet->mergeCells('A' . $column .':A' . $next);
                $activeSheet->mergeCells('B' . $column .':B' . $next);
                $activeSheet->mergeCells('C' . $column .':C' . $next);
                $activeSheet->mergeCells('D' . $column .':D' . $next);
                $activeSheet->mergeCells('E' . $column .':E' . $next);
                $activeSheet->mergeCells('F' . $column .':F' . $next);
                $activeSheet->mergeCells('G' . $column .':G' . $next);
                $activeSheet->mergeCells('H' . $column .':H' . $next);
                $activeSheet->mergeCells('I' . $column .':I' . $next);
                $activeSheet->mergeCells('J' . $column .':J' . $next);
                $activeSheet->mergeCells('K' . $column .':K' . $next);
            }

            $nextC = 0;
            $str = '';
            $strArr = [];
            foreach ($value['device'] as $val){

                $activeSheet->getStyle('L' . ($column + $nextC))->applyFromArray($font);
                $activeSheet->getStyle('M' . ($column + $nextC))->applyFromArray($font);
                $activeSheet->getStyle('N' . ($column + $nextC))->applyFromArray($font);
                $activeSheet->getStyle('O' . ($column + $nextC))->applyFromArray($font);

                $activeSheet->setCellValue('L' . ($column + $nextC), $val['isWireless']);
                $activeSheet->setCellValue('M' . ($column + $nextC), $val['deviceType']);
                $activeSheet->setCellValue('N' . ($column + $nextC), $val['imei']);
                $activeSheet->setCellValue('O' . ($column + $nextC), $val['position']);
                $nextC++;
                if(!isset($strArr[$val['isWireless']]))$strArr[$val['isWireless']] = 0;
                $strArr[$val['isWireless']] += 1;
            }

            foreach ($strArr as $key => $val){
                $str .= $key . '*' . $val . ',';
            }
            $str = trim($str , ', ');
            $activeSheet->getStyle('A' . $column .':A' . $next)->applyFromArray($font);
            $activeSheet->getStyle('B' . $column .':B' . $next)->applyFromArray($font);
            $activeSheet->getStyle('C' . $column .':C' . $next)->applyFromArray($font);
            $activeSheet->getStyle('D' . $column .':D' . $next)->applyFromArray($font);
            $activeSheet->getStyle('E' . $column .':E' . $next)->applyFromArray($font);
            $activeSheet->getStyle('F' . $column .':F' . $next)->applyFromArray($font);
            $activeSheet->getStyle('G' . $column .':G' . $next)->applyFromArray($font);
            $activeSheet->getStyle('H' . $column .':H' . $next)->applyFromArray($font);
            $activeSheet->getStyle('I' . $column .':I' . $next)->applyFromArray($font);
            $activeSheet->getStyle('J' . $column .':J' . $next)->applyFromArray($font);
            $activeSheet->getStyle('K' . $column .':K' . $next)->applyFromArray($font);

            $activeSheet->setCellValue('A' . $column, $n++);
            $activeSheet->setCellValue('B' . $column, $value['orderTime']);
            $activeSheet->setCellValue('C' . $column, $value['mastersName']);
            $activeSheet->setCellValue('D' . $column, $value['operation']);
            $activeSheet->setCellValue('E' . $column, $value['shelfCode']);
            $activeSheet->setCellValue('F' . $column, $value['plateNum']);
            $activeSheet->setCellValue('G' . $column, $value['carType']);
            $activeSheet->setCellValue('H' . $column, $value['installRegion']);
            $activeSheet->setCellValue('I' . $column, $value['taskTime']);
            $activeSheet->setCellValue('J' . $column, $value['createTime']);
            $activeSheet->setCellValue('K' . $column, $str);
            $column = $column + $num;
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function installInfo($req){
        $where['oiid'] = $req['oiid'];
        $installInfo = $this->where($where)->find();
        if(empty($installInfo)){
            return false;
        }
        $installInfo = $installInfo->toArray();
        $order = (new OrderModel())->alias('o')
            ->join($this->userModel . ' u' , 'u.uid = o.uid' , 'LEFT')
            ->join($this->userModel . ' m' , 'm.uid = o.masters')
            ->field('o.orderNum , o.taskTime , u.userName name , m.userName mastersName , m.mobile mastersMobile')
            ->where('o.oid' , $installInfo['oid'])
            ->find();
        $installInfo['orderNum'] = !empty($order['orderNum']) ? $order['orderNum'] : '';
        $installInfo['taskTime'] = !empty($order['taskTime']) ? $order['taskTime'] : '';
        $installInfo['name'] = !empty($order['name']) ? $order['name'] : '';
        $installInfo['mastersName'] = !empty($order['mastersName']) ? $order['mastersName'] : '';
        $installInfo['mastersMobile'] = !empty($order['mastersMobile']) ? $order['mastersMobile'] : '';
        $installInfo['installDevice'] = [];
        $installDevice = (new OrderInstallDeviceModel())->where($where)->field('oid , oiid' , true)->select();
        foreach ($installDevice as $info){
            $info = $info->getData();
            $info['imei'] = $info['imei'] ? $info['imei'] : '';
            $info['deviceType'] = $info['deviceType'] ? $info['deviceType'] : '';
            $info['isWireless'] = $info['deviceType'] ? ($info['isWireless'] ? '无线' : '有线') : '';
            $info['isMapgoo'] = $info['deviceType'] ? '是' : '否';
            $info['images'] = $info['images'] ? explode(',' , $info['images']) : [];
            $info['remark'] = $info['remark'] ? $info['remark'] : '';
            $installInfo['installDevice'][] = $info;
        }
        return $installInfo;
    }

    public function installDel($req){
        $where['oiid'] = ['in',$req['oiid']];
        try{
            $this->where($where)->delete();
            (new OrderInstallDeviceModel())->where($where)->delete();
        }catch (Exception $e){
            return false;
        }
        return true;
    }
}