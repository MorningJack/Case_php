<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/3 11:09
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use app\admin\command\Statistics;
use think\Model;

class UserBehaviorModel extends Model
{
    protected $table = 'b_user_behavior';

    public $modleName = [
        'INDEX'=>'驾驶行为报告','PLUS1440G'=>'PLUS1440G','PLUS120G'=>'PLUS120G','PLUS240G'=>'PLUS240G','PLUS480G'=>'PLUS480G','bargain'=>'砍价','JD'=>'点击京东',
        'INDEXCOUNT' => '每日页面访问量', 'SHOPCOUNT'  => '每日微商城访问量', 'SHARECOUNT' => '每日分享量', 'READTHROUGH' => '每日阅读完成量', 'ERRORCOUNT' => '未找到车辆信息'
    ];
    /**
     * NAME: saveData 写入多条数据
     * @param $saveData
     * @param $date
     * @return \think\Collection
     */
    public function saveData($saveData)
    {
        $data = array();
        $date = date("Y-m-d",strtotime('- 1day'));
        foreach ($saveData as $k => $v) {//转换成k=>v
            $data[$k]['name'] = $v[0];
            $data[$k]['modelName'] = $v[1];
            $data[$k]['pv'] = $v[2]['PV'];
            $data[$k]['uv'] = $v[2]['UV'];
            $data[$k]['summaryTime'] = $date;
            $exist = $this->where(['name' => $data[$k]['name'],  'summaryTime' => $data[$k]['summaryTime']])->find();
            if($exist){
                unset($data[$k]);
            }
        }
        return $this->allowField(true)->saveAll($data);
    }

    public function getList($req)
    {
        $res = array();
        $where['summaryTime'] = getTimeRang($req);//获取时间范围
        $field = ['name', 'modelName', 'pv', 'uv', 'summaryTime'];
        $total = $this->where($where)->count();
        $res = [];
        $res['total'] = $total;
        $data = $this
            ->field($field)
            ->where($where)
            ->page($req['pageNum'], $req['pageSize'])
            ->order('summaryTime desc')
            ->select();
        foreach ($data as $k=>$v) {
           $info = $v->getData();
           $info['name'] = isset($this->modleName[$info['modelName']])?$this->modleName[$info['modelName']]:$info['modelName'];
           $res['row'][] = $info;
        }
        return $res;
    }
}