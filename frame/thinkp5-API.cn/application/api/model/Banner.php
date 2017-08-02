<?php

/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/24
 * Time: 下午10:25
 */
namespace app\api\model;


class Banner extends BaseModel
{
    protected $hidden = ['update_time','delete_time'];
//    protected $visible = [''];
    /*1.原生sql
     *2.查询构建器
     *
     * */
    //protected $table = '';
    /* 关联模型 */
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }

/*    public function image(){
        return ;
    }*/

    public static function getBannerById($id){
        //1.Db::query('select * from sql where id =?',[$id]);
        $bannerList = self::with(['items','items.image'])->find($id);
        //TODO：根据Banner ID号 获取Banner信息
        //$bannerList = Db::table('banner_item')->where('banner_id','=',$id)->select();
        //日志记录是全局功能
        return $bannerList;
    }
}