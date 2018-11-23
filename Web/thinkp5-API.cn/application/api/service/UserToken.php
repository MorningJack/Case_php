<?php

/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/5/31
 * Time: 下午12:00
 */
namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\USer as UserModel;

class UserToken
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID,$this->wxAppSecret,$this->code);
    }

    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            throw new Exception('获取session_key及openID时异常,微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult){
        //拿到openid
        //数据库里看一下，openid是否存在
        //存在不处理，不存在新增
        //准备缓存数据，写入缓存
        //把令牌返回客户端
        //key:令牌
        //value:wxResult,uid,scope(决定访问权限)
        $openid = $wxResult['openid'];
        $user = USerModel::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }else{
            $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cachedValue){
        $key = self::generateToken();
        $value = json_decode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $request = cache($key,$value,$expire_in);
        if(!$request){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

    private function newUser($openid){
        $user = USerModel::create([
            'openid' => $openid,
        ]);
        return $user->id;
    }


    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}