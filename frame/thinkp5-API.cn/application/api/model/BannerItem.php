<?php

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];
    public function image(){
        return $this->belongsTo('image','img_id','id');
    }
}
