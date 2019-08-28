<?php
/**
 * Created by PhpStorm.
 * Author: ztl
 * Date: 2018/6/8 15:06
 * Email: 1465@mapgoo.net
 */

namespace app\admin\model;


use app\admin\server\MenuServer;
use think\Model;

class FunModel extends Model
{
    protected $table = 's_fun';

    /**
     * 通过funAction 查找对应的模块名称以及具体的事件意义
     * @param array $req
     * @return array
     */
    public function funInfo($req)
    {
        //$where['funAction'] = $req;
        $where['funAction'] = array('like','%'.$req.'%');
        $field = 'fid,funName,funMenu,parentFun,describe';
        $data   = $this->where($where)->field($field)->select();
        if($data){
            $info = [];
            foreach($data  as  $v){
                $reg['funName'] = $v['funName'];
                $reg['api_name'] = $req;
                $reg['describe'] = $v['describe'];
                $reg['parentFun'] = $v['parentFun'];
                $info[] = $reg;
            }
            $count = count($info);
            if($count == 1){
                //说明是单独菜单拥有的api 根据fid,parentFun找出完整模块
                $module = $this->findModule($info[0]['parentFun'],$info[0]['funName']);
                $info[0]['funName'] = $module;//充填funName
                return $info[0];
            }else {
                $org = [];
                //如果有多条记录 表示该接口有多个模块用到 取记录日志的最后一条记录的模块方法作为其信息
                $log = $this->table('s_log')->where('type=2')->order('time desc')->find()->toArray();
                $org['funName']  = $log['module_name'];
                $org['api_name'] = $log['api_name'];
                $org['describe'] = $info[0]['describe'];
                return $org;
            }
        }else {
            $org = [];
            $org['funName']  = '';
            $org['api_name'] = '';
            $org['describe'] = '';
            return $org;
        }

    }

    //根据parentFun递归获取funName
    public function findModule($parentFun,$str = ''){
        $info = $this->field('parentFun,funName')->where('fid='.$parentFun)->find();
        if($info['parentFun'] !=0){
            $tree = $this->findModule($info['parentFun'],$info['funName'].'/'.$str);
        }else {
            $tree =   $info['funName'].'/'.$str;
        }
        return $tree;
    }

    //查询所有的菜单
    public  function  getAllList($req)
    {
        $where = [];
        if(!empty($req['status'])){
            $where['status'] = $req['status'];
        }
        /*if(!empty($req['funName'])){
            $where['funName'] = ['like', "%{$req['funName']}%"];
        }
        if(trim($req['parentFun']) !=''){
            $where['parentFun'] = $req['parentFun'];
        }*/
        $filed = 'fid, funName, funAction, funMenu, parentFun, sort, describe, status,outLink';
        $res   = $this->where($where)->field($filed)->order('sort asc,fid')->select();
        $result  = [];
        if($res){
            foreach($res as $key => $val){
                $result[] = $val->getData();
                if(!isset($val['child'])){
                    $result[$key]['child'] = [];
                }
            }
        }
        return $result;
    }

    //menu新增
    public function add($req,$action)
    {
        $req['status'] = 1;        
        if($action){
            $result = $this->create($req);
            $pid = $result->fid;
            $save = $data = [];
            foreach($action as $k=>$v){
                if($v){
                    $data = explode(':', $v);
                    $save[$k]['status'] = 1;
                    $save[$k]['funAction'] = $data[1];
                    $save[$k]['funName'] = $data[0];
                    $save[$k]['parentFun'] = $pid;
                }
            }
            $this->saveAll($save);
        }else{
            $result = $this->create($req);
        }
        return $result ? true : false;
    }

    public function edit($req,$action)
    {
        $param = [];
        $save = [];
        foreach($req as $k=>$v){
            if(trim($req[$k])){
                $param[$k] = $v;
            }
        }
        $data = $info = $funData = $fid = [];
        $funList = $this->where(['parentFun'=>$req['fid']])->field('fid')->select();
        foreach($funList as $v){
            $funData[] = $v->getData('fid');
        }
        foreach($action as $ak=>$av){
            $data = explode(':', $av);            
            if(count($data) < 3){                
                $save[$ak]['funName'] = $data[0];
                $save[$ak]['funAction'] = trim($data[1]);
                $save[$ak]['parentFun'] = $req['fid'];
                $save[$ak]['status'] = 1;        
            }else{                 
                $fid[] = $data[0];
                $update['fid'] = $data[0];
                $update['funName'] = $data[1];
                $update['funAction'] = trim($data[2]);
                $update['parentFun'] = $req['fid'];
                $update['status'] = 1;
                $this->where(['fid'=>$data[0]])->update($update); 
            } 
        }
        if(array_diff($funData,$fid)){
            $this->where(['fid'=>['in',array_diff($funData,$fid)]])->delete();
        }
        $this->where(['fid'=>$req['fid']])->update($param);
        if(count($save) > 0){
            $this->saveAll($save);
        }
        return true;
    }

    public function getInfo($req)
    {
        $result = [];
        $data = $this->where(['fid'=>$req['fid']])->find();
        if(!empty($data)){
            $result = $data->toArray();
        }
        $child = $this->field('fid,funName,funAction')->where(['parentFun'=>$req['fid']])->select();
        $info = '';
        $data = [];
        
        foreach($child as $k=>$v){
            $info = $v->getData();
            $data[] = implode(':', $info);
        }
        $result['subFunAction'] = implode("\r\n", $data);
        return $result;
    }

    public function delMenu($req)
    {
        /* 1.获取id所有下级id
         * 2.删除ids
         */
        $status = $req['handle'] ? 0 : 1;
        $quest = ['parentFun' => $req['fid'] , 'status' => $status];
        $data   = $this->getAllList($quest);
        $ids = (new MenuServer())->getChildIds($data,$req['fid']);
        $ids[] = $req['fid'];
        $where['fid'] = ['in',$ids];
        return $this->where($where)->update(['status' => $req['handle']]);
    }
}