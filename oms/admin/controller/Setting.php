<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/28 12:00
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;


use app\admin\model\SettingModel;
use think\Request;

class Setting
{
    public function protocolEdit(Request $request){
        $res = [
            'value' => $request->param('content' , '')
        ];
        $settingModel = new SettingModel();
        $op = $settingModel->editSetting('protocol' , $res['value']);
        if($op){
            ajax_info(0 , 'success');
        }else{
            ajax_info(1, '修改失败');
        }
    }

    public function protocolInfo(Request $request){
        $settingModel = new SettingModel();
        $protocol = $settingModel->where('key' , 'protocol')->find();
        ajax_info(0 , 'success' , $protocol ? $protocol['value'] : '');
    }
}