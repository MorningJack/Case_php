<?php
/**
 * 标签助手类
 * @time 2019-01-03 15:53
 * @author guoguo
 */

namespace app\common\helper;

use app\oms\model\BasPackageLableModel;
class LableHelper {
    public $lableModel = '';
    public $lablePackageField = ['project', 'factory'];
    public $lableField = ['lifecycle', 'rcxSubscriber', 'jlzSubscriber', 'rcxRegister', 'jlzRegister', 'active',
        'koowo', 'member', 'number', 'renew', 'packet', 'blackwell'];
    public $lableExField = ['packages', 'firewallService'];
    public $listField = 'project,group_concat(factory) factory,lifecycle, rcxSubscriber, jlzSubscriber,rcxRegister, jlzRegister, active,koowo,member,number,renew,packet,blackwell, packages, firewallService';
    public $indexField = 'p.pid,p.package,p.packageType,p.remark,p.packageName,p.user,p.crowd,p.createTime,p.isAddPackage,p.isUsageReset,p.packageFlow,p.sort,p.packageUse,
    p.packageTime,p.state,p.price,p.renewNum,alias,l.rcxSubscriber, l.jlzSubscriber,l.project,l.factory,l.rcxRegister, l.jlzRegister, l.active,
    l.koowo,l.lifecycle,l.member,l.number,l.renew,l.packet,l.blackwell,l.packages, l.firewallService';

    public function __construct() {
        $this->lableModel = new BasPackageLableModel();
    }

    /**
     * 组装查询语句
     * @param array $req
     * @return string
     */
    public function buildPackageWhere($req = [])
    {
        $w = '';
        $i = 0;
        foreach ($this->lableField as $v) {
            if (!empty($req[$v])) {
                if ($i === 0) {
                    $w .= 'if(' . $v . ' = 0 , 1, ' . $req[$v] . ' & ' . $v . ' > 0)';
                } else {
                    $w .= ' and if(' . $v . ' = 0 , 1, ' . $req[$v] . ' & ' . $v . ' > 0)';
                }
                $i++;
            }
        }
        foreach ($this->lableExField as $v) {
            if (!empty($req[$v])) {
                if ($i === 0) {
                    $w .= 'if(' . $v . ' = 0 , 1, ' . $req[$v] . ' & ' . $v . ' > 0)';
                } else {
                    $w .= ' and if(' . $v . ' = 0 , 1, ' . $req[$v] . ' & ' . $v . ' > 0)';
                }
                $i++;
            }
        }
        return $w;
    }

    /**
     * 根据标签生成表达式
     * @param int $lable   标签一期
     * @param int $lableEx  标签二期
     * @param string $alias  别名
     * @return string
     */
    public function buildLableWhere($lable = 0, $lableEx = 0, $alias = '')
    {
        $w = '';
        $i = 0;
        foreach ($this->lableField as $v) {
            if ($i === 0) {
                $w .= 'if(' .($alias ? $alias . '.' : '') . $v . ' = 0 , 1, ' . $lable . ' & ' . ($alias ? $alias . '.' : '') . $v . ' > 0)';
            } else {
                $w .= ' and if('. ($alias ? $alias . '.' : '') . $v . ' = 0 , 1, ' . $lable . ' & ' . ($alias ? $alias . '.' : '') . $v . ' > 0)';
            }
            $i++;
        }
        foreach ($this->lableExField as $v) {
            if ($i === 0) {
                $w .= 'if(' . ($alias ? $alias . '.' : '') . $v . ' = 0 , 1, ' . $lableEx . ' & ' . ($alias ? $alias . '.' : '') . $v . ' > 0)';
            } else {
                $w .= ' and if('. ($alias ? $alias . '.' : '')  . $v . ' = 0 , 1, ' . $lableEx . ' & ' . ($alias ? $alias . '.' : '') . $v . ' > 0)';
            }
            $i++;
        }
        return $w;
    }

    /**
     * 标签基本查询
     * @param array $req  请求参数
     * @return string
     */
    public function buildBaseLable($req = [], $alias = '')
    {
        $w = '';
        $i = 0;
        foreach ($this->lableField as $v) {
            if (!empty($req[$v])) {
                if ($i === 0) {
                    $w .= $req[$v] . ' & '. ($alias ? $alias . '.' : '') . 'lable > 0';
                } else {
                    $w .= ' and ' . $req[$v] . ' & '. ($alias ? $alias . '.' : '') . 'lable > 0';
                }
                $i++;
            }
        }
        foreach ($this->lableExField as $v){
            if (!empty($req[$v])) {
                if ($i === 0) {
                    $w .= $req[$v] . ' & '. ($alias ? $alias . '.' : '') . 'lableEx > 0';
                } else {
                    $w .= ' and ' . $req[$v] . ' & '. ($alias ? $alias . '.' : '') . 'lableEx > 0';
                }
                $i++;
            }
        }
        return $w;
    }

    /**
     * 返回所有标签相关项
     * @return array
     */
    public function lablePackage()
    {
        return array_merge($this->lablePackageField, $this->lableField, $this->lableExField);
    }

    /**
     * 返回所有标签相关项
     * @return array
     */
    public function lableFiledArr()
    {
        return array_merge($this->lableField, $this->lableExField);
    }

    /**
     * 组装sql查找字段
     * @param string $alias
     * @return string
     */
    public function lablePackageByFiled($alias = '')
    {
        $lable = $this->lablePackage();
        foreach ($lable as $k => $v){
            $lable[$k] = $alias . '.' . $v;
        }
        return implode(',', $lable);
    }

    public function createLable($lable,$id,$type = 0,$edit = 0){
        $i = 0;
        $saveAll = [];
        foreach ($lable as $key => $value) {
            $multipleFactory = explode(',',$value['factory']);
            foreach ($multipleFactory as $k => $v){
                $info['id'] = $id;
                $info['strategy'] = $i;
                $info['project'] = !empty($value['project']) ? $value['project'] : '';
                $info['factory'] = !empty($v) ? $v : '';
                $info['rcxRegister'] = $value['rcxRegister'];
                $info['jlzRegister'] = $value['jlzRegister'];
                $info['rcxSubscriber'] = $value['rcxSubscriber'];
                $info['jlzSubscriber'] = $value['jlzSubscriber'];
                $info['active'] = $value['active'];
                $info['koowo'] = $value['koowo'];
                $info['lifecycle'] = $value['lifecycle'];
                $info['member'] = $value['member'];
                $info['number'] = $value['number'];
                $info['renew'] = $value['renew'];
                $info['packet'] = $value['packet'];
                $info['blackwell'] = $value['blackwell'];
                $info['packages'] = $value['packages'];
                $info['firewallService'] = $value['firewallService'];
                $info['type'] = $type;
                $saveAll[] = $info;
            }
            $i++;
        }
        if($edit){ //如果是修改标签
            $this->lableModel->where(['id'=>$id,'type'=>$type])->delete();
        }
        if($saveAll)$this->lableModel->saveAll($saveAll);
        return true;
    }
    
    public function lableInfo($id,$type) {
        $lable = $this->lableModel
                ->where(['id'=>$id,'type'=>$type])
                ->field($this->listField)
                ->group('strategy')
                ->select();
        $data = [];
        foreach($lable as $v){
            $info = $v->getData();
            $factory = $info['factory'] ? explode(',', $info['factory']) : [];
            $f = [];
            foreach ($factory as $kk => $vv){
                if($vv)$f[] = $vv;
            }
            $info['project'] =  $info['project'] ?  $info['project'] : '';
            $info['factory'] = $f ? implode(',', array_unique($f)) : '';
            $data[] = $info;
        }
        return $data;
    }
    
}
