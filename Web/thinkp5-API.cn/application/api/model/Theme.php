<?php

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = [
        'delete_time','update_time'
    ];
    //一对多
    public function topicImg(){
//        $this->hasOne()
        return $this->belongsTo('Image','topic_img_id','id');
    }
    //一对多
    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }
    //多对多
    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }
    /*获取主题商品*/
    public static function getThemeWithProducts($id){
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}
