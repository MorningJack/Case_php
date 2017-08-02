<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/6/6
 * Time: 下午7:02
 */

namespace app\api\controller\v1;



use app\api\Validate\OrderPlace;
use app\api\service\Token as TokenService;

class Order extends BaseController
{
    //用户在选择商品后，提交包含所选择商品的相关信息
    //1.api接收信息后，需要检查订单相关商品的库存量
    //有库存，把订单数据存入数据库中（下单成功），通知可以支付
    //跳用我们的支付接口，运行支付
    //2.还需要再次进行库存量检测
    //服务器调用支付接口进行支付
    //微信返回支付结果，判断是否支付成功（异步）
    //3.成功进行库存量检测
    //成功，进行库存量的扣除，失败，返回一个支付失败的结果

    /*前置方法*/
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $product = input('post.products/a');//获取数组参数
        $uid = TokenService::getCurrentUid();
    }

}