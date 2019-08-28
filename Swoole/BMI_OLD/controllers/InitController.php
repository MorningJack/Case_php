<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/2/24
 * Time: 15:29
 * Email: 1183@mapgoo.net
 */

class InitController
{
    /**
     * 初始化方法
     */
    public $request = array();
	protected $domian = null;
	public function __construct($Domian , $Request = array()){
		$this->request = $Request;
		$this->domian = $Domian;
	}
    public function initAction()
    {	
		return $this->jsonResponse(Api_Define::$ICE_RESULT_ERROR['status'], Api_Define::$ICE_RESULT_ERROR['info']);
    }

    /**
     *json返回给前端数据
     */
    protected function jsonResponse($error = 0 , $reason = 'success' , $arr = null){
		return json_encode(array('error'=>$error,'reason'=>$reason,'result'=>$arr));
    }
}