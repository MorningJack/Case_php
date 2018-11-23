<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/18
 * Time: 下午10:34
 */

namespace app\api\controller\v2;
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
        return 'This is version2';
    }
}