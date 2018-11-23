<?php

namespace app\api\model;



class ProductProperty extends BaseModel
{
    protected $hidden = [
        'create_time',
        'id',
        'product_id'
    ];

}
