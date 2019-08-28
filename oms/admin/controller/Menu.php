<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/1/29 18:13
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;

use app\admin\model\FunModel;
use app\admin\server\MenuServer;
use app\admin\validate\MenuValidate;
use think\Request;

class Menu
{
    public function menuList(Request $request){
        $req = [
            'funName'     => $request->param('funName' , '') ,
            'parentFun'   => $request->param('parentFun' , '') ,
            'status'      => $request->param('status' ,1 ,'intval') ,
        ];

        $validate = new MenuValidate();
        if(!$validate->scene('menulist')->check($req)){
            ajax_info(1 , $validate->getError());
        }

        $result = (new MenuServer())->menuList($req);
        ajax_info(0 , 'success' , $result);
    }

    public function add(Request $request){
        $req = [
            'funName'     => $request->param('funName' , '') ,
            'funAction'   => $request->param('funAction' ,'') ,
            'funMenu'     => $request->param('funMenu' ,'') ,
            'parentFun'   => $request->param('parentFun' , 0 , 'intval') ,
            'sort'        => $request->param('sort' ,  0 , 'intval') ,
            'outLink'        => $request->param('outLink' ,  '') ,
            'describe'    => $request->param('describe' , '') ,
            'subFunAction' => $request->param('subFunAction',''),
        ];

        $validate = new MenuValidate();
        if(!$validate->scene('add')->check($req)){
            ajax_info(1 , $validate->getError());
        }

        $result = (new MenuServer())->add($req);
        ajax_info(0 , 'success' , $result);
    }

    public function edit(Request $request){
        $req = [
            'fid'         => $request->param('fid' , '') ,
            'funName'     => $request->param('funName' , '') ,
            'funAction'   => $request->param('funAction' ,'') ,
            'funMenu'     => $request->param('funMenu' ,'') ,
            'parentFun'   => $request->param('parentFun' , '') ,
            'sort'        => $request->param('sort' ,  '') ,
            'describe'    => $request->param('describe' , '') ,
            'outLink'    => $request->param('outLink' , '') ,
            'status'      => $request->param('status' , '') ,
            'subFunAction' => $request->param('subFunAction',''),
        ];

        $validate = new MenuValidate();
        if(!$validate->scene('edit')->check($req)){
            ajax_info(1 , $validate->getError());
        }

        $result = (new MenuServer())->edit($req);
        if($result){
            ajax_info(0 , 'success' , $result);
        }else {
            ajax_info(1 , '数据没有被修改' );
        }
    }

    //详细信息
    public function getInfo(Request $request)
    {
        $req = [
            'fid'=> $request->param('fid' , '') ,
        ];

        $validate = new MenuValidate();
        if(!$validate->scene('info')->check($req)){
            ajax_info(1 , $validate->getError());
        }

        $result = (new MenuServer())->getInfo($req);
        ajax_info(0 , 'success' , $result);

    }

    /**
     * NAME: delMenus 隐藏菜单
     * @param Request $request
     */
    public function delMenus(Request $request)
    {
        $req['fid'] = $request->get('fid','');
        $req['handle'] = $request->get('handle',0);// [0 => 隐藏 1=>显示]
        if($req['fid'] <= 0){ajax_info(1,'删除参数有误');}
        (new FunModel())->delMenu($req);
        ajax_info(0,'success');
    }
}
