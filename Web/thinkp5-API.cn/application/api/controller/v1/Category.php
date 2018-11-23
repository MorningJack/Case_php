<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/31
 * Time: 上午10:42
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;


class Category
{
    public function getAllCategories(){
        $categories = CategoryModel::all([],'img');
        if($categories){
            throw new CategoryException();
        }
        return $categories;
    }
}