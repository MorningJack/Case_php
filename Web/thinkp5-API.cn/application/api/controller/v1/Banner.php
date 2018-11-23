<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/18
 * Time: 下午10:34
 */

namespace app\api\controller\v1;
use app\api\Validate\IDMustBepostiveInt;
use app\lib\exception\BannerMissException;
use think\validate;
use app\api\model\Banner as BannerModel;
class Banner
{
    /**
     * 获取制定id的banner信息
     * @http GET
     * @URL /banner/:id
     * @id banner的id号
     */
    public function getBanner($id)
    {
        (new IDMustBepostiveInt())->goCheck();
        $banner = BannerModel::getBannerById($id);
//        $banner->hidden(['delete_time']);  隐藏
//        $banner->visible(['']); 显示
        if(!$banner){
//            log('error) 记录日志
            throw new BannerMissException();
        }
        $c = config('setting.img_prefix');
        return json($banner);

        //不好的写法--完整的异常处理流程
        /*(new IDMustBePostiveInt())->goCheck();*/
       /* try{
            $banner = BannerModel::getBannerById($id);
        }catch(\Exception $ex){
            $err = [
                'error_code' => 10001,
                'msg' => $ex->getMessage()
            ];
            return json($err,400);
        }
        return $banner;*/


    /*    $data = [
            'name' => 'vendor111111',
            'email' => 'vendor@qq.com'
        ];
        $validate = new validate([
            'name' => 'require|max:10',
            'email' => 'email'
        ]);
        $result = $validate->batch()->check($data);*/
        //$validate->getError();错误信息
    }
}