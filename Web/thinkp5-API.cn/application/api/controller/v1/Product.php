<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/31
 * Time: 上午12:51
 */

namespace app\api\controller\v1;


use app\api\Validate\Count;
use app\api\model\Product as ProductModel;
use app\api\Validate\IDMustBepostiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count){
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id){
        (new IDMustBepostiveInt())->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        if($products->isEmpty()){
            throw new ProductException();
        }
        return $products;
    }

    public function getOne($id){
        (new IDMustBepostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }

    public function deleteOne($id){

    }
}