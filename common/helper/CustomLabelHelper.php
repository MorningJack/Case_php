<?php
/**
 * 标签助手类
 * @time 2019-01-03 15:53
 * @author guoguo
 */

namespace app\common\helper;

use app\oms\model\BasLabelRelationModel;
use app\oms\model\BasLabelSubRelationModel;
use app\oms\model\BasMdtLabelRelationModel;
use app\oms\model\BasMdtLableModel;
use app\oms\model\CustomLabelModel;
use app\oms\model\TagsHoldModel;

class CustomLabelHelper
{

    public function __construct()
    {
        $this->labelModel = new BasLabelRelationModel();
    }



    /*
     * 1.存入
     * 2.删除
     */
    //单个label查询条件构造
    public function buildSingleLWhere($label)
    {
        $where = [];
        $specWhere = [];
        $havingWhere = [];
        if (!empty($label['project'])) {
            $where['blr.project'] = ['in' ,$label['project'].' ,""'];
        }

        if (!empty($label['factory'])) {
            $where['blr.factory'] = ['in', $label['factory'].' ,""'];
        }
        //特殊查询条件
        if(!empty($label['label'])){
            //实际查询条目 大于等于 传来 的标签数量
            $labelArr =  explode(',',(string)$label['label']);
            $labelCount = count($labelArr);
            $havingWhere  ='num >= ' . $labelCount;

            $specWhere['blsr.labelId'] =  ['in' ,$label['label']];
        }

        return ['where' => $where , 'spec' => $specWhere, 'have' => $havingWhere];
    }

    public function buildLabelWhere($label = [], $type = 0)
    {
        if(empty($label['project']) && empty($label['factory']) && empty($label['label'])){
            return false;
        }

        $where['blr.type'] = $type;
        if (!empty($label['project'])) {
            $where['blr.project'] = ['exp' , 'in("'.$label['project'].'", "")'];
        }
        if (!empty($label['factory'])) {
            $where['blr.factory'] = ['exp' , 'in("'.$label['factory'].'", "")'];
        }

        $field = 'blr.sourceId';

        $buildSql = (new BasLabelRelationModel())->alias('blr')->field($field);
        if(!empty($label['label'])){
            $total = count(explode(',', $label['label']));
            $basLabelSubRelationModel = new BasLabelSubRelationModel();
            $buildGroupSqlStr = $basLabelSubRelationModel->buildGroupSqlStr($label['label']);
            $buildGroupSqlStrUnlimited = $basLabelSubRelationModel->buildGroupSqlStrUnlimited($label['label']);
            $buildSql->join($buildGroupSqlStr . ' blsr', 'blsr.pid = blr.id', 'LEFT');
            $buildSql->join($buildGroupSqlStrUnlimited . ' blsru', 'blsru.pid = blr.id', 'LEFT');
            $where[] = ['exp', 'blsr.num = '.$total.' OR blr.total = 0 OR blr.total = (IFNULL(blsru.unlimited, 0) + IFNULL(blsr.num, 0))'];
        }

        $list = $buildSql->where($where)->group($field)->buildSql();
        return $list;
    }

    //多个条件查询
    public function buildMultiLWhere($req)
    {
        $where = [];
        foreach ($req as $key => $value) {
            $where[] = $this->buildSingleLWhere($value);
        }
        return $where;
    }

    //新增&更新套餐label
    public function createLabelLists($labelLists, $sourceId, $type, $isUpdate = false)
    {

        $labelModel = new BasLabelRelationModel();
        $subLabelModel = new BasLabelSubRelationModel();
        if (count($labelLists) < 1) {
            return false;
        }
        //根据project分裂数据
        $labelLists = $this->separateArrParam($labelLists, 'factory');
        //查询所有标签
        $labelInfo = (new CustomLabelModel())->where(['pid' => ['gt', 0]])->select();
        $labels = [];
        foreach ($labelInfo as $k => $v){
            $labels[$v['id']] = $v['pid'];
        }

        //删除历史数据
        if ($isUpdate) {
            $res = $this->deleteLabels($sourceId , $type);
        }
        foreach ($labelLists as $key => $value) {//
            $subLabelSave = [];
            $labelSave = [];
            $label = $value['label'] ? explode(',', $value['label']) : [];
            $labelSave['type'] = (int)$type;
            $labelSave['sourceId'] = (int)$sourceId;
            $labelSave['factory'] = (string)$value['factory'];
            $labelSave['project'] = (string)$value['project'];
            $labelSave['groupId'] = (int)$value['groupId'];
            $labelSave['createTime'] = time();
            $labelSave['updateTime'] = time();
            $labelSave['total'] = count($label) < 1 ? 0 : count($label);
            //存入标签
            $pid = $labelModel->saveOne($labelSave);
            if (!$pid) {
                return false;
            }
            if(count($label) < 1){//没有label则跳过标签新增
                continue;
            }
            foreach ($label as $k => $v) {
                $subLabelSave[$k]['pid'] = $pid;
                $subLabelSave[$k]['labelId'] = $v;
                $subLabelSave[$k]['labelPid'] = !empty($labels[$v]) ? $labels[$v] : 0;
            }
            //存入标签子关系
            $res = $subLabelModel->saveAll($subLabelSave);
            if (!$res) {
                return false;
            }
        }
        return true;
    }

    /**
     * NAME: separateArrParam 分离数组中某个数组元素，裂变成新的数组
     */
    public function separateArrParam($list, $param)
    {
        $resData = [];
        $i = 0;
        $groupId = 0;
        foreach ($list as $key => $value) {
            //对字段进行裂变
            $value[$param] = (string)$value[$param];
            $paramArr = explode(',', $value[$param]);
            if (count($paramArr) < 1) {
                continue;
            }
            unset($value[$param]);
            foreach ($paramArr as $k => $v) {
                $resData[$i][$param] = $v;
                $resData[$i]['groupId'] = $groupId;
                $resData[$i] = $resData[$i] + $value;
                $i++;
            }
            $groupId ++;
        }
        return $resData;
    }

    /**
     * NAME: deleteLabels 删除标签
     * @param $pid
     * @param $type
     */
    public function deleteLabels($sourceId, $type)
    {
        $labelModel = new BasLabelRelationModel();
        $subLabelModel = new BasLabelSubRelationModel();
        $pids = $labelModel->getInfo('GROUP_CONCAT(id) ids',['sourceId' => ['in' , $sourceId]]);
        if(empty($pids['ids'])){
            return false;
        }
        $res = $labelModel->where(['sourceId' => ['in' , $sourceId], 'type' => $type])->delete();
        if(!$res){
            return false;
        }
        $res = $subLabelModel->where(['pid' => ['in' , $pids['ids']]])->delete();
        if(!$res){
            return false;
        }
        return true;
    }


    public function labelMultiLBuildSql($lableArr = [], &$buildSql)
    {
        if($lableArr){
            $buildRelationSql = (new BasMdtLabelRelationModel())->alias('r')
                ->join('bas_mdt_lable a', 'a.objectId = r.objectid')
                ->field('r.objectId');
        }
        foreach ($lableArr as $k => $req){
            $where = [];
            if($req['label']){
                $req['label'] = explode(',', $req['label']);
                $w = $this->labelBuildWhere($req['label']);
                foreach ($w['labelToBigDataWhere'] as $v){
                    $where[] = $v;
                }
                foreach ($w['labelToOmsWhere'] as $v){
                    $where[] = $v;
                }
            }
            if(!empty($req['project']) || !empty($req['factory'])){
                $w = [];
                if(!empty($req['factory'])){
                    $w['t.factory'] = ['in', $req['factory']];
                }
                if(!empty($req['project'])){
                    $w['t.project'] = ['in', $req['project']];
                }
                $build = (new TagsHoldModel())->alias('h')
                    ->join('tags_configuration t', '`t`.`tagid`=`h`.`tagId`', 'LEFT')
                    ->where($w)
                    ->field('`h`.`holdId`')
                    ->buildSql();
                $where['a.holdid'] = ['exp', 'in(' . $build . ')'];
            }
            if(!$where){
                $where[] = ['exp', '1=1'];
            }
            if($where){
                $buildRelationSql = $buildRelationSql->whereOr(function($query) use ($where){
                    $query->where($where);
                });
            }

        }
        if(!empty($buildRelationSql)){
            $sql = $buildRelationSql->buildSql();
            //$buildSql->where(['a.objectid' => ['exp', 'in('.$relationFiltrate.')']]);
            $buildSql->join($sql . ' f', 'a.objectid = f.objectId');
        }
    }

    public function labelBuildSql($label = [], $type = 'and')
    {
        if(!$label)return false;
        $label = explode(',', $label);
        sort($label);
        $where = $this->labelBuildWhere($label);
        $basMdtLabelRelationModel = new BasMdtLabelRelationModel();
        $where = array_merge($where['labelToBigDataWhere'], $where['labelToOmsWhere']);
        if($type == 'and'){
            $subQuery = $basMdtLabelRelationModel
                ->where($where)
                ->field('objectId')
                ->buildSql();
        }else{
            $subQuery = $basMdtLabelRelationModel
                ->whereOr($where)
                ->field('objectId')
                ->buildSql();
        }
        return $subQuery;
    }

    public function labelBuildWhere($label = [])
    {
        $bigDataLabel = [2,3,4,5,7,8,10,11,13,14,16,17,19,20,22,23,24,26,27,28,30,31,32,34,35,37,38,40,41,50,51,53,54,56,57,58,60,61,62,63,64,81, 86, 87, 89, 90];
        $labelToBigDataWhere = [];
        $labelToOmsWhere = [];
        foreach ($label as $v){
            $v = (int)$v;
            if(in_array($v, $bigDataLabel, true)){
                $labelToBigDataWhere[] = ["exp", "FIND_IN_SET({$v}, labelToBigData)"];
            }else{
                $labelToOmsWhere[] = ["exp", "FIND_IN_SET({$v}, labelToOms)"];
            }
        }
        return ['labelToBigDataWhere' => $labelToBigDataWhere, 'labelToOmsWhere' => $labelToOmsWhere];
    }

    public function labelMerge($labelToBigData = '', $labelToOms = '')
    {
        $labelArr = [];
        if(!empty($labelToBigData)){
            $labelToBigData = explode(',', $labelToBigData);
            foreach ($labelToBigData as $value){
                $labelArr[] = $value;
            }
        }
        if(!empty($labelToOms)){
            $labelToOms = explode(',', $labelToOms);
            foreach ($labelToOms as $value){
                $labelArr[] = $value;
            }
        }
        return array_unique($labelArr);
    }

    public function labelInfo($sourceId , $type)
    {
        return $this->labelModel->getListByJoin('GROUP_CONCAT(distinct blr.factory) factory,GROUP_CONCAT(distinct blr.project) project,GROUP_CONCAT(distinct blsr.labelId) label',
            ['blr.sourceId' => $sourceId , 'blr.type' => $type] ,'blr.groupId');
    }

    public function labelReplace($objectInfo, &$objectLabel, $labelArr = [], $label = 0)
    {
        $replace = false;
        if($objectInfo){
            foreach ($objectLabel as $k => &$value){
                if(in_array((int)$value, $labelArr, true)){
                    if($label){
                        $value = $label;
                    }else{
                        unset($objectLabel[$k]);
                    }
                    $replace = true;
                    break;
                }
            }
        }
        if(!$replace && $label){
            $objectLabel[] = $label;
        }
    }
}
