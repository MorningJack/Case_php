<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/8/9
 * Time: 11:13
 */

namespace app\admin\server;

use app\admin\model\FunModel;

class MenuServer
{

    private $funModel = '';

    public function __construct()
    {
        $this->funModel = new FunModel();
    }

    public function menuList($req)
    {
        $root = 0;
        if($req['parentFun'] > 0){
            $root = $req['parentFun'];
        }
        $data   = $this->funModel->getAllList($req);
        $result = $this->generateTree($data,'fid','parentFun','child',$root);

        return $result;
    }


    public function add($req)
    {      
        $req['subFunAction'] = str_replace("：", ":", $req['subFunAction']);
        $action = [];
        if($req['subFunAction']){
            $trim = trim($req['subFunAction']);
            $action = explode("\n", $trim);
        }   
        unset($req['subFunAction']);      
        $result = $this->funModel->add($req,$action);
        return $result;
    }

    public function edit($req)
    {
        $req['subFunAction'] = str_replace("：", ":", $req['subFunAction']);
        $action = [];
        if($req['subFunAction']){
            $trim = trim($req['subFunAction']);
            $action = array_filter(explode("\n", $trim));
        }
        unset($req['subFunAction']); 
        $result = $this->funModel->edit($req,$action);
        return $result;
    }

    public function getInfo($req)
    {
        $result = $this->funModel->getInfo($req);
        return $result;
    }

    //无限极分类
    function generateTree($list, $pk='fid', $pid='parentFun', $child='child', $root=0){
        $tree = [];
        foreach($list as $key => $val){
            if($val[$pid] == $root){
                //获取当前$pid所有子类
                unset($list[$key]);
                if(!empty($list)){
                    $child=$this->generateTree($list,$pk,$pid,$child,$val[$pk]);
                    if(!empty($child)){
                        $val['child'] = $child;
                    }
                }
                $tree[]=$val;
            }
        }
        return $tree;
    }

    public function getChildIds($data , $id)
    {
        static $ids = array();
        foreach ($data as $k =>$v){
            if($v['parentFun'] == $id){
                $ids[] = $v['fid'];
                $this->getChildIds($data ,$v['fid']);
            }
        }
        return $ids;
    }

}