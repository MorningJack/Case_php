<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/6 11:45
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use think\Exception;
use think\Log;
use think\Model;

class RoleFunModel extends Model
{
    protected $table = 's_role_fun';
    public $fid = array();
    /**
     * 获取角色所有权限ID
     * @param array $req
     * @return array
     */
    public function roleFun($req)
    {
        $res = $this->where(['rid' => $req['rid']])->field('fid')->select();
        
        $funObj = new FunModel();
        $response = [];
        foreach ($res as $value){
            $response[] = $value->getData('fid');
        }
        $parentFun = $funObj->field('parentFun')->where(['fid'=>['in',implode(',', $response)]])->select();
        $data = [];       
        foreach($parentFun as $value){
           $data[] = $value->getData('parentFun');
        }
        $parentFid = array_unique($data);
        $fid = array_diff($response,$parentFid);
        return implode(',', $fid);
    }

    /**
     * 权限分配
     * @param array $req
     * @return bool
     */
    public function roleFunUpdate($req)
    {
        //禁止修改管理员账号信息
        if($req['rid'] == 1){
            return false;
        }
        $ffid = explode(',', $req['fid']);
        $fid = $this->getPfid($req['fid']);
        $pfis = array_merge($ffid,$fid); 
        $funArr = array_unique($pfis);
        foreach ($funArr as $value){
            $saveAll[] = [
                'rid'  =>  $req['rid'],
                'fid'  =>  $value
            ];
        }
        $this->startTrans();
        try{
            $this->where(['rid' => $req['rid']])->delete();
            $this->saveAll($saveAll);
            $this->commit();
        }catch (Exception $e){
            Log::sql('RoleFunUpdate Error : '.$e->getMessage());
            $this->rollback();
            return false;
        }
        return true;
    }
    
    public function getPfid($fid){
        $where['fid'] = ['in',$fid];
        $pfid = (new FunModel())->field('parentFun')->where($where)->select();   
        $info = [];
        foreach($pfid as $v){
            $fids = $v->getData();
            if($fids['parentFun'] != 0){
                array_push($info,$fids['parentFun']);
                array_push($this->fid,$fids['parentFun']);
            }            
        }
        if($info){
            $fid = implode(',', array_unique($info)); 
            $pfid = self::getPfid($fid);
        }     
        return $this->fid;
    }
}