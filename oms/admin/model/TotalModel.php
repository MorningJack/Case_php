<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 20:15
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use think\Model;

class TotalModel extends Model
{
    protected $table = 's_total';

    public function getWeekTotal($f = '*'){
        $end = date('Y-m-d');
        $start = date('Y-m-d' , strtotime('-1 week' , strtotime($end)));
        $field = $f . ' , time';
        $where = 'time >= "' . $start . '" and time < "' . $end . '"';
        $list = $this->where($where)->field($field)->select();
        $data = [];
        foreach ($list as $k=>$v){
            $data[$v['time']] = $v[$f];
        }
        $n = 7;
        $res['time'] = $res['total'] = [];
        for ($i = 0; $i < $n; $i++){
            $t = date('Y-m-d' , strtotime('+' . $i . ' day' , strtotime($start)));
            $res['time'][] = date('m.d' , strtotime($t));
            $res['total'][] = isset($data[$t]) ? $data[$t] : 0;
        }
        return $res;
    }
}