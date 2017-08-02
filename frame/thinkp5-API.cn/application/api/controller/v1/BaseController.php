<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/6/6
 * Time: 下午7:31
 */

namespace app\api\controller\v1;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }
}