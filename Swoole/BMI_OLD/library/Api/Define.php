<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/3/3
 * Time: 14:46
 * Email: 1183@mapgoo.net
 */
class Api_Define
{
    public static $ICE_CONNECT_ERROR = array('status'=>-10,'info'=>'ice 连接出错');
    public static $ICE_RESULT_ERROR = array('status'=>-11,'info'=>'ice 返回出错');

	
    public static $PARAM_JSON_ERROR = array('status'=>-1,'info'=>'参数解析错误');
    public static $PARAM_DEFAULT_ERROR = array('status'=>-2,'info'=>'参数缺少或不正确');
	public static $PARAM_MORE_ERROR = array('status'=>-3,'info'=>'不能同时传入多个设备参数');

    public static $DATA_RESULT_EMPTY = array('status'=>10,'info'=>'没有数据');

	public static $RETURN_FALL = array('status'=>-4,'info'=>'处理失败');
	public static $RETURN_NOT_FOUND = array('status'=>-5,'info'=>'Object无效');
	public static $RETURN_SEND_IN = array('status'=>-6,'info'=>'待发送');
	
	public static $ROUTE_ISNULL = array('status'=>-7,'info'=>'获取路由失败');
	public static $CODING_FALL = array('status'=>-8,'info'=>'获取发送编码失败');


	public static $RETURN_SUCCESS = array('status'=>0,'info'=>'success');
}