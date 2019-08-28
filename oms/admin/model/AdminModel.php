<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 17:37
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use think\Cache;
use think\Db;
use think\Exception;
use think\Log;
use think\Model;
use app\admin\model\LogModel;

class AdminModel extends Model
{
    protected $table = 's_admin';
    protected $pk = 'aid';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'createTime';
    protected $updateTime = '';

    private $adminRole = 's_admin_role';
    private $role = 's_role';

    protected function base($query)
    {
        $query->where($this->table.'.isDelete' , 0);
    }

    public function getFieldByWhere($where = [] , $field = '*'){
        return $this->field($field)->where($where)->find();
    }

    public function login($req , $password = true){
        $where['userName'] = $req['userName'];
        $admin = $this->getFieldByWhere($where , 'aid , userName , nickName,userPass , salt, loginCount');
        if(empty($admin['aid'])){
            $this->errMsg = '账号不存在';
            return false;
        }
        $admin = $admin->toArray();
        if($password){
            if(MD5($req['userPass'] . $admin['salt']) != $admin['userPass']){
                $this->errMsg = '密码不正确';
                return false;
            }
        }

        $index = $this->alias('a')->join('s_admin_role b','a.aid = b.aid ')->join('s_role c','b.rid=c.rid')->where(['a.aid'=>$admin['aid']])->field('c.index,c.indexName')->find();
        $info['index'] = '';
        $info['indexName'] = '';
        if($index){
            $info = $index->toArray();
        }
        $index['index'] = !empty($info['index'])?$info['index']:'';
        $index['indexName'] = !empty($info['indexName'])?$info['indexName']:'';
        $user['aid'] = $admin['aid'];
        $user['loginCount'] = ['exp' , 'loginCount + 1'];
        $user['loginTime'] = date('Y-m-d H:i:s');
        $user['loginIp'] = getClientIp();
        /*. $user['loginIp']*/
        $user['token'] = MD5($admin['aid']. getClientIp());
        $expireTime = config('token.expire_time');
        Cache::set('token_'  . $user['token'], $user['aid'], $expireTime);
        try{
            $this->update($user);
        }catch (Exception $e){
            Log::sql('AdminLogin Error : '.$e->getMessage());
            $this->errMsg = '登录失败';
            return false;
        }
        $res['userName'] = $admin['userName'];
        $res['token'] = $user['token'];
        $res['nickName'] = $admin['nickName'];
        $res['index'] = $index['index'];
        $res['indexName'] = $index['indexName'];
        //添加登录日志
        $org = $user;
        $org['name']  = $req['userName'];
        $org['count'] = $admin['loginCount']+1;
        $logModel = new LogModel();
        $logModel->loginLogAdd($org);
        unset($org);

        return $res;
    }

    /**
     * NAME: logout 登出清除token
     * $token 用户唯一标识
     */
    public function logout($token)
    {
        $where['token'] = $token;
        return $this->where($where)
            ->update(['token'=>'']);
    }

    public function userPermission($aid , $isMenu = true , $action = ''){
        $where = [];
        $where['f.status'] = 1;
        if($isMenu){
            $where['f.funMenu'] = ['exp' , 'is not null'];
        }
        if($action && $aid != 1){
            $where[] = ['exp', "find_in_set('{$action}', f.funAction)"];
        }
        if($aid == 1){
            $prmissions = (new FunModel())->alias('f')->where($where)->order('sort asc,fid')->field('f.fid, f.funName, f.funMenu, f.parentFun,f.outLink')->select();
        }else{
            $w['u.aid'] = $aid;
			$prmissions = [];
            $role = $this->alias('u')
                ->join('s_admin_role ar' , 'ar.aid = u.aid')
                ->join('s_role r' , 'r.rid = ar.rid and r.isDelete = 0')
				->field('r.rid')
				->where($w)
				->select();

			if($role){
				$roleArr = [];
				foreach($role as $value){
					$roleArr[] = (int)$value['rid'];
				}
				if(in_array(1, $roleArr, true)){
					if(isset($where[0]))unset($where[0]);
					$prmissions = (new FunModel())->alias('f')->where($where)->field('f.fid, f.funName, f.sort,f.funMenu, f.parentFun,f.outLink')->order('sort asc,fid')->select();
				}else{
					$where['rf.rid'] = ['in', $roleArr];
					$prmissions = (new RoleFunModel())->alias('rf')
							->join('s_fun f' , 'f.fid = rf.fid')
							->order('sort asc,fid')
							->where($where)
							->field('f.fid, f.funName, f.funMenu, f.parentFun,f.outLink')
							->select();
				}
			}
        }
        return $prmissions;
    }

    /**
     * NAME: getPermissionTree 获取菜单树
     * @param $aid
     * @param bool $isMenu
     * @return array
     */
    public function getPermissionTree($aid, $isMenu = true){
        $permission = $this->userPermission($aid, $isMenu);

        $arr = [];
        foreach ($permission as $value){
            $arr[] = $value->getData();
        }
        $fMenuArr = $this->favorMenu($aid);
        foreach ($arr as $k => $v) {//增加iscom字段，前端判断
            if(in_array($v['fid'],$fMenuArr)){
                $arr[$k]['iscom'] = 1;
            }else{
                $arr[$k]['iscom'] = 0;
            }
        }
        $res = $this->treeArr($arr);
        return $res;
    }

    /**
     * NAME: favorMenu 获取用户常用功能
     * @param $aid 用户ID
     * @return array
     */
    private function favorMenu($aid)
    {
        $fMenu = $this->where('aid',$aid)->value('permission');
        return explode(',',$fMenu);
    }

    public function treeArr($arr , $treeArr = [] , $pid = 0){
        foreach ($arr as $k=>$v){
            if($v['parentFun'] == $pid){
                unset($arr[$k]);
                $childArr = $v;
                $childArr['children'] =  $this->treeArr($arr , [] , $v['fid']);
                $treeArr[] = $childArr;
            }
        }
        return $treeArr;
    }

    /**
     * 管理员列表
     * @param array $req
     * @return mixed
     */
    public function admin($req)
    {
        $where = [];
        $count = $this->alias('a')->where($where)->count();
        $response['total'] = !empty($count) ? $count : 0;
        $response['rows'] = [];
        $field = 'a.aid, a.userName, a.nickName, a.remark, a.createTime, a.updateTime, a.loginCount, a.loginTime, a.loginIp, GROUP_CONCAT(r.roleName) roleName';
        $res = $this->alias('a')
            ->join($this->adminRole . ' ar', 'ar.aid = a.aid','LEFT')
            ->join($this->role . ' r', 'r.rid = ar.rid','LEFT')
            ->field($field)
            ->order('a.createTime desc')
            ->group('a.aid')
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
    public function adminInfo($req)
    {
        $where['a.aid'] = $req['aid'];
        $field = "a.aid, a.userName, a.nickName, a.remark,a.loginCount, a.loginTime, a.loginIp, GROUP_CONCAT(ar.rid) rid";
        $info = $this->alias('a')->field($field)->join($this->adminRole . ' ar', 'ar.aid = a.aid')->where($where)->find();
        if(!$info){
            return false;
        }
        $info = $info->getData();
        $info['rid'] = (int)$info['rid'];
        return $info;
    }

    /**
     * 管理员删除
     * @param array $req
     * @return bool
     */
    public function adminDelete($req)
    {
        $where['aid'] = [['in', $req['aid']], ['neq', 1]];
        $this->startTrans();
        try{
            $this->save(['isDelete' => 1], $where);
            (new AdminRoleModel())->where($where)->delete();
            $this->commit();
        }catch (Exception $e){
            Log::sql('AdminDelete Error : '.$e->getMessage());
            $this->rollback();
            return false;
        }
        return true;
    }

    /**
     * 管理员添加|删除
     * @param array $req
     * @return bool
     */
    public function adminUpdate($req)
    {
        $save['userName']   = $req['userName'];
		if($req['userPass']){
			$save['salt']       = getRandStr();
			$save['userPass']   = md5($req['userPass'] . $save['salt']);
		}
        $save['updateTime'] = date('Y-m-d H:i:s');
        $save['nickName'] = $req['nickName'];
        $save['remark'] = $req['remark'];
        $role = explode(',', $req['rid']);
        $this->startTrans();
        try{
            if(isset($req['aid'])){
                $where['aid'] = $req['aid'];
                $this->save($save, $where);
                if($req['aid'] != 1)(new AdminRoleModel())->where($where)->delete();
                $aid = $req['aid'];
            }else{
                $admin = $this->create($save);
                $aid = $admin->aid;
            }
			if($aid != 1){
				$saveAll = [];
				foreach ($role as $value){
					$saveAll[] = [
						'aid'  =>  $aid,
						'rid'  =>  $value
					];
				}
				(new AdminRoleModel())->saveAll($saveAll);
			}
            $this->commit();
        }catch (Exception $e){
            Log::sql('AdminUpdate Error : '.$e->getMessage());
            $this->rollback();
            return false;
        }
        return true;
    }
    
    public function editCommon($req){
        
        $o = $this->save([
            'permission' => trim($req['permission'],','),
            'updateTime' => date('Y-m-d H:i:s',time())
        ],['aid' => $req['aid']]);
        
        if($o){
            return array('status'=>0,'result'=>$req['permission']);
        }else{
            return array('status'=>1,'result'=>'服务器出错请稍后重试');
        }
    }
}