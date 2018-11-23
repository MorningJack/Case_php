<?php

namespace app\api\model;



class ProductImage extends BaseModel
{
    protected $hidden = [
        'create_time',
        'update_time',
        'ima_id'
    ];

    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');;
    }

}
