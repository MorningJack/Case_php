<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/2/5 18:49
 * Email: 1183@mapgoo.net
 */

namespace app\admin\controller;


use app\admin\behavior\Check;
use app\admin\model\AdminModel;
use Qiniu\Auth;
use think\Request;

class Permission
{
    public function userPermission(Request $request)
    {
        $aid = Check::$aid;
        $adminModel = new AdminModel();
        $res = $adminModel->getPermissionTree($aid);
        ajax_info(0, 'success', $res);
    }

    public function permission(Request $request)
    {
        $aid = Check::$aid;
        $adminModel = new AdminModel();
        $res = $adminModel->getPermissionTree($aid, false);
        ajax_info(0, 'success', $res);
    }

    /**
     * NAME: getQiniuToken
     * $param bucket 存储空间名称
     * @return jsonArr
     */
    public function getQiniuToken(Request $request)
    {
        import('vender/qiniu/php-sdk/autoload.php');
        $bucket = $request->param('bucket', '');
        $qiniuConfigure = config('configQiniu');
        if (empty($bucket)) {
            $bucket = $qiniuConfigure['bucket'];
        }
        $auth = new Auth($qiniuConfigure['accessKey'], $qiniuConfigure['secretKey']);
        $token = $auth->uploadToken($bucket);
        $res = [
            'token' => $token,
            'uploadUrl' => $qiniuConfigure['uploadUrl'],
            'clouddnUrl' => $qiniuConfigure['clouddnUrl'],
        ];
        ajax_info(0, 'success', $res);
    }
}