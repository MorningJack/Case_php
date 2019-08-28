<?php
/**
 * Created by PhpStorm.
 * Author: ztl
 * Date: 2018/6/8 15:06
 * Email: 1465@mapgoo.net
 */

namespace app\admin\model;


use think\Model;

class LogModel extends Model
{
    protected $table = 's_log';

    /**
     * 添加登录日志
     * @param array array
     * @return array
     */
    public function loginLogAdd($array)
    {

        $data  = [];
        $data['name'] = isset($array['name']) ?  $array['name'] : '';
        $data['aid']  = isset($array['aid']) ?  $array['aid'] : '';
        $data['ip']   = isset($array['loginIp']) ?  $array['loginIp'] : '';
        $data['type'] = 1;
        $data['login_count']  = isset($array['count']) ?  $array['count'] : 0;
        $data['last_time'] = isset($array['loginTime']) ?  $array['loginTime'] : '';
        $data['time'] = date('Y-m-d H:i:s');

        $this->create($data);

        return true;
    }

    /**
     * 添加操作日志
     * @param array array
     * @return array
     */
    public function operationLogAdd($array)
    {
        $data  = [];
        $data['aid']  = isset($array['aid']) ?  $array['aid'] : '';
        $data['name'] = isset($array['name']) ?  $array['name'] : '';
        $data['ip']   = isset($array['ip']) ?  $array['ip'] : '';
        $data['type'] = 2;
        $data['module_name']  = isset($array['module_name']) ?  $array['module_name'] : '';
        $data['api_name']     = isset($array['api_name']) ?  $array['api_name'] : '';
        $data['remark']       = isset($array['remark']) ?  $array['remark'] : '';
        $data['time']         = date('Y-m-d H:i:s');

        $this->create($data);

        return true;
    }

    public function oplog($req){
               
        $where = [];        
        if($req['type']){
             $where['type'] = ['like','%'.$req['type'].'%'];
        }
        if($req['name']){
            $where['name'] = ['like','%'.$req['name'].'%'];
        }
        $total = $this->where($where)->count(); 
        $list = $this->where($where)->page($req['pageNum'] , $req['pageSize'])->order('time desc')->select();
        $row = [];
        foreach($list as $v){
            $data = $v->getData();
            $row['rows'][] = $data;
        }
        $row['total'] = $total;
        return $row;
    }
}