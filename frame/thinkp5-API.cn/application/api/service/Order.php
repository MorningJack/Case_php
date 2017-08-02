<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/6/6
 * Time: 下午9:53
 */

namespace app\api\service;


use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;

class Order
{
    //订单的商品列表，也就是客户端传递过来的products参数
    protected $oProducts;

    //真实的商品信息（包括库存量）
    protected $products;

    protected $uid;

    public function place($uid,$oProducts){
        //oproducts 和 products 对比
        //products从数据库查询出来真实商品信息（包含库存量）
        $this->oProducts = $oProducts;

        $this->products = $this->getProductsByOrder($oProducts);

        $this->uid = $uid;

        $status = $this->getOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }//开始创建订单
        $orderSnap = $this->snapOrder();
    }

    //生成订单快照
    private function snapOrder($status){
        $snap = [//订单快照信息
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImage' => ''
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImage'] = $this->products[0]['main_img_url'];

        if(count($this->products) > 1){
            $snap['snapName'] = $this->products[0]['name'].'等';
        }
    }

    private function createOrder($snap){
        $orderNo = self::makeOrderNo();

        $order = new OrderModel();
        $order->user_id = $this->uid;
        $order->order_no = $orderNo;
        $order->total_price = $snap['orderPrice'];
        $order->total_count = $snap['totalCount'];
        $order->snap_img = $snap['snapImg'];
        $order->snap_name = $snap['snapName'];
        $order->snap_address = $snap['snapAddress'];
        $order->snap_items = json_encode($snap['pStatus']);

        $order->save();
    }

    public static function makeOrderNo(){//创建订单号
        $yCode = array('A','B','C','D','E','F','G','H','I','J');
        $orderSn = $yCode[intval(date('Y')) - 2017].strtoupper(dechex(date('m'))).date(
            'd').substr(time(),-5).substr(microtime(),2,5).sprintf(
                '%02d',rand(0,99));
        return $orderSn;
    }

    //生成订单
    private function getUserAddress(){
        $userAddress = UserAddress::where('user_id','=',$this->uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户收获地址不存在，下单失败',
                'errorCode' => 60001,
            ]);
        }
        return $userAddress->toArray();
    }

    public function getOrderStatus(){
        $status = [//定义返回属性
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []//历史订单:保存订单商品详细信息
        ];

        foreach ($this->oProducts as $oProduct){
            $pStatus = $this->getProductStatus(
              $oProduct['product_id'],$oProduct['count'],$this->products
            );
            if(!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID , $oCount , $products){
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
            ];
        for($i = 0;$i<count($products); $i++){
            if($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }

        if($pIndex == -1){//客户端传递的product_id有可能不存在
            throw new OrderException([
                'msg' => 'id为'.$oPID.'的商品不存在，创建订单失败'
            ]);
        }else{
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if($product['stock'] - $oCount >=0){
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

    //根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts){
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs,$item['product_id']);
        }
        $Products = Product::all([$oPIDs])
            ->visible(['id','price','stock','name','main_img_url'])//可见字段
            ->toArray();
        return $Products;
    }
}