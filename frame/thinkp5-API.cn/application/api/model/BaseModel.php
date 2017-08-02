<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{

/*    pro function getUrlAttr($value,$data){//读取器
        $finaUrl = $value;
        if($data['from'] == 1){
            $finaUrl = config('setting.img_prefix').$value;
        }
        return $finaUrl;
    }*/
    protected function prefixImgUrl($value,$data){//读取器
        $finaUrl = $value;
        if($data['from'] == 1){
            $finaUrl = config('setting.img_prefix').$value;
        }
        return $finaUrl;
    }
}
