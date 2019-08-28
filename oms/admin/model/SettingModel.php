<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/28 12:03
 * Email: 1183@mapgoo.net
 */

namespace app\admin\model;


use think\Model;

class SettingModel extends Model
{
    protected $table = 'd_setting';

    public function editSetting($key = '' , $value = ''){
        if(!$key || !$value)return false;
        $setting = $this->where('key' , $key)->field('key')->find();
        if(empty($setting)){
            $op = $this->save(['key' => $key , 'value' => $value]);
        }else{
            $op = $this->save(['value' => $value] , ['key' => $key]);
        }
        if($op){
            return true;
        }else{
            return false;
        }
    }
}