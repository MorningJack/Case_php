<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/6/5
 * Time: 下午4:25
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = [
        'id','delete_time','user_id'
    ];
}