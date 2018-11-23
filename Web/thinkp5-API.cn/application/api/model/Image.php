<?php

namespace app\api\model;



class Image extends BaseModel
{
    protected $hidden = ['id','from','delete_time','update_time'];

    public function getUrlAttr($value,$data){//读取器
        return $this->prefixImgUrl($value,$data);
    }

}
