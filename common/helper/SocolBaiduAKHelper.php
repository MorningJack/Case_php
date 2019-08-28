<?php
/**
 * 百度ak解密类
 * @time 2019-07-22 14:36
 * @author guoguo
 */
namespace app\common\helper;

class SocolBaiduAKHelper {
    
    public static function rc4($pwd, $data){
        $key[] = "";
        $box[] = "";
        $pwd_length = strlen($pwd);
        $data_length = strlen($data);
        $cipher = [];
        for ($i = 0; $i < 256; $i++) {
            $key[$i] = ord($pwd[$i % $pwd_length]);
            $box[$i] = $i;
        }
        $j = $i = 0;
        for (; $i < 256; $i++) {
            $j = ($j + $box[$i] + $key[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        $a = $j = $i = 0;
        for (; $i < $data_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $k = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher [] = chr(ord($data[$i]) ^ $k);
        }
        return implode("", $cipher);
    }
    
    public static function tencode($data, $key, $salt_length = 16)
    {
        $salt = '';
        for ($i = 0; $i < $salt_length; $i++) {
            $salt .= chr(random_int(0, 256));
        }
        $data = $salt . SocolBaiduAKHelper::rc4($key, $data);
        $data = base64_encode($data);
        return $data;
    }
    
    public static function tdecode($data, $key, $salt_length=16){
        $data = base64_decode($data);
        $data = substr($data,$salt_length);
        $decode_result = SocolBaiduAKHelper::rc4($key, $data);
        return $decode_result;

    }
    
    /**
     * 百度签名
     */
    public static function bSN($req,$ak){        
        ksort($req);
        $_sign_key = array();
        if (!array_key_exists('_sign_key', $req)){
            foreach ($req as $k => $v) {
                $_sign_key []= $k;
            }
        }else{
            $_sign_key = $req['_sign_key'];
        }
        $requestValue = '';
        if ($req) {
            foreach ($req as $k => $v) {
                if (in_array($k, $_sign_key)){
                    $requestValue .= $v . '|';
                }
            }
        }
        return md5($requestValue . $ak);
    }
}
