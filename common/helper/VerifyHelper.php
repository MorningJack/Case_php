<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/6/8
 * Time: 9:36
 * File: VerifyHelper.php
 */

namespace app\common\helper;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class VerifyHelper
{
    /**
     * 生成验证码
     */
    public static function verify()
    {
        $phraseBuilder = new PhraseBuilder(4,'abcdehkmnszxvwrtu123456789');
        $builder = new CaptchaBuilder(null,$phraseBuilder);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->build()->output();
        $builder->build(80,40,null);
        session('verifyCode', $builder->getPhrase());
    }
    /**
     * 检测验证码是否正确
     * @param $code
     * @return bool
     */
    public static function check($code)
    {
        $code = strtolower($code);
        return ($code == session('verifyCode') && $code != '') ? true : false;
    }
}