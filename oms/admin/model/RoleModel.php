<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/6 11:32
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use think\Exception;
use think\Log;
use think\Model;

class RoleModel extends Model
{
    protected $table = 's_role';
    protected $pk = 'rid';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';

    protected function base($query)
    {
        $query->where($this->table.'.isDelete' , 0);
    }

    /**
     * 角色列表
     * @param array $req
     * @return mixed
     */
    public function role($req)
    {
        $where = [];
        $count = $this->where($where)->count();
        $response['total'] = !empty($count) ? $count : 0;
        $response['rows'] = [];
        $field = 'rid, roleName, remark, createTime, updateTime,index,indexName';
        $res = $this
            ->field($field)
            ->order('createTime desc')
            ->page($req['pageNum'], $req['pageSize'])
            ->select();
        foreach ($res as $value){
            $info = $value->getData();
            $response['rows'][] = $info;
        }
        return $response;
    }

    /**
     * 管理员详情
     * @param array $req
     * @return array|bool|false|mixed|\PDOStatement|string|Model
     */
    public function roleInfo($req)
    {
        $where['rid'] = $req['rid'];
        $field = "rid, roleName, remark,index,indexName";
        $info = $this->field($field)->where($where)->find();
        if(!$info){
            return false;
        }
        $info = $info->getData();
        return $info;
    }

    /**
     * 管理员删除
     * @param array $req
     * @return bool
     */
    public function roleDelete($req)
    {
        $where['rid'] = [['in', $req['rid']], ['neq', 1]];
        $this->startTrans();
        try{
            $this->save(['isDelete' => 1], $where);
            (new RoleFunModel())->where($where)->delete();
            $this->commit();
        }catch (Exception $e){
            Log::sql('RoleDelete Error : '.$e->getMessage());
            $this->rollback();
            return false;
        }
        return true;
    }

    /**
     * 权限新增|修改
     * @param array $req
     * @return bool
     */
    public function roleUpdate($req)
    {
        $save['roleName'] = $req['roleName'];
        $save['remark'] = $req['remark'];
        $save['index'] = $req['index'];
        $save['indexName'] = $req['indexName'];
        $fid['fid'] = $req['fid'];
        try{
            if(isset($req['rid'])){
                $rid = $req['rid'];
                $fid['rid'] = $rid;
                $this->save($save, ['rid' => $req['rid']]);
            }else{
                $rid = $this->create($save);
                $fid['rid'] = $rid->rid;
            }
        }catch (Exception $e){
            Log::sql('RoleUpdate Error : '.$e->getMessage());
            return false;
        }
        //在添加和修改角色的时候可以直接直接修改角色权限
        (new RoleFunModel())->roleFunUpdate($fid);
        return true;
    }

    /**
     * NAME: roleSelect 返回下拉框角色列
     * @return mixed
     */
    public function roleSelect(){
        $response['rows'] = [];
        $field = 'rid, roleName';
        $res = $this
            ->field($field)
            ->order('updateTime desc')
            ->select();
        foreach ($res as $value){
            $info = $value->getData();
            $response['rows'][] = $info;
        }
        return $response;
    }
}