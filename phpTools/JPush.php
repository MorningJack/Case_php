<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/1 20:18
 * Email: 1183@mapgoo.net
 */

namespace app\wheatTravelFront\extend\jpush;


use app\index\extend\HttpClient;
use think\Config;
use think\Log;

class JPush
{
    private $appKey;
    private $secret;

    public function __construct($config = [])
    {
        if(empty($config)){
            $config = Config::get('push');
        }
        foreach ($config as $k => $v){
            $this->{$k} = !$this->checkEmpty($v) ? $v : '';
        }
    }

    public function pushAlias($alias , $title , $extras = []){
        $url = Config::get('OPENAPI.JPushUrl');
        $pushMsg['platform'] = ["android", "ios"];
        $pushMsg['audience']['alias'] = $alias;
        $extras['notifyContent'] = isset($extras['notifyContent']) ? $extras['notifyContent'] : $title;
        $extras['notifyTime'] = date('Y-m-d H:i');
        if(empty($extras['notifyImg']))$extras['notifyImg'] = '';
        if(empty($extras['notifyUrl']))$extras['notifyUrl'] = '';
        if(empty($extras['oid']))$extras['oid'] = 0;
        $pushMsg['notification']['ios'] = [
            "alert"  => $title,
            "sound"  => "default",
			"badge"  => "+1",
            "content-available" => true,
            'extras' => $extras,
        ];
        $pushMsg['notification']['android'] = [
            'alert' => $title,
            'extras' => $extras,
        ];
        $pushMsg['options'] = [
            'time_to_live' => 0,
            'apns_production' => true,
        ];
        $http = new HttpClient();
        $http->setHeader('Authorization' , 'Basic ' . base64_encode($this->appKey . ':' . $this->secret));
        $http->setHeader('Content-Type' , 'application/json');
        $response = $http->Request($url , 'POST' , json_encode($pushMsg));
        $i = 0;
        //发送失败，重试三次
        while (!$response && $i < 3){
            $response = $http->Request($url , 'POST' , json_encode($pushMsg));
            $i++;
        }
        $response = json_decode($response , true);
        if(isset($response['msg_id']) && isset($response['sendno'])){
            return true;
        }else{
            Log::error('PushAlias Error Response: '.print_r ($response , true));
        }
        return true;
    }

    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }
}