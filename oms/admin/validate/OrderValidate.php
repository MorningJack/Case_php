<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/5/7 17:13
 * Email: 1183@mapgoo.net
 */

namespace app\admin\validate;


use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'brand'       => 'require',
        'taskTime'    => 'require',
        'masters'     => 'require',
        'contacts'    => 'require',
        'mobile'      => 'require',
        'reward'      => 'require|between:0,999999',
        'prov'        => 'require',
        'city'        => 'require',
        'lat'         => 'require',
        'lng'         => 'require',
        'path'        => 'require|checkPath',
        'title'       => 'require',
    ];

    protected $message  =   [
        'brand'           => '请选择品牌',
        'taskTime'        => '请选择任务时间',
        'masters'         => '请选择指派师傅',
        'contacts'        => '请输入联系人',
        'mobile'          => '请输入联系电话',
        'reward.require'  => '请输入报酬',
        'reward.between'  => '超出金额范围',
        'prov'            => '省份不能为空',
        'city'            => '城市不能为空',
        'lat'             => '纬度未获取',
        'lng'             => '经度未获取',
        'path'            => '文件不能为空',
        'title'           => '订单名称不能为空'
    ];

    protected $scene = [
        'add'     =>  ['brand', 'taskTime', 'masters', 'contacts', 'mobile', 'reward', 'prov', 'city', 'lat', 'lng'],
        'update'  =>  ['brand', 'masters', 'contacts', 'mobile', 'prov', 'city', 'lat', 'lng', 'title'],
        'path'    =>  ['path']
    ];

    public function checkPath($path , $rule , $data)
    {
        if(!file_exists('.' . DS . $path)){
            return '文件路径有误';
        }
        $this->path = '.' . DS . $path;
        return true;
    }
}