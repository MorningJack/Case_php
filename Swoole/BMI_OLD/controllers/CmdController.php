    <?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/9/27
 * Time: 16:46
 * Email: 1183@mapgoo.net
 */
class CmdController extends InitController
{
	
    public function sendAction(){
		if(empty($this->request['content'])){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']  .'content不能为空');
		}
		if(empty($this->request['objID']) && empty($this->request['imei'])){
			return $this->jsonResponse(Api_Define::$PARAM_DEFAULT_ERROR['status'], Api_Define::$PARAM_DEFAULT_ERROR['info']  .'objID,imei不能同时为空');
		}

		$message = array(
			'DownID' => 11,
			//'ObjectID' => $objID,
			'sendContent' => $this->request['content'],
			'CMDTypeID'  => (int)$this->request['cmdTypeID'],
			'SubmitTime' => date("Y-m-d H:i:s"),
			'sendUserID' => (int)$this->request['sendUserID'],
			'sim' => !empty($this->request['sim']) ?  $this->request['sim'] : "",
			'remark' => !empty($this->request['remark']) ?  $this->request['remark'] : "",
			'sendFlag' => 0,
			'sendsource' => 153,
			'TransType' => 0,
			'DownInfoType' => 1502,
			'seq' => !empty($this->request['seq']) ?  $this->request['seq'] : $this->createUUID(),
		);

		if(empty($this->request['objID']) && !empty($this->request['imei']) ){
			$imei = $this->request['imei'];
			$res  = $this->domian->GetObjectinfoByImeiSSV($imei);
		}else {
			$objID = (int)$this->request['objID'];
			$res   = $this->domian->GetObjectinfoById($objID);
		}

		if($res['status'] === 0){
			$returnResult = $res['data']->objInfo;
			$objID        = $returnResult->ObjectID;
			$message['ObjectID'] = $objID;
			if(!empty($res['data']->ssvid) && $res['data']->captureType == 1 && (stristr($message['sendContent'] , 'image') || stristr($message['sendContent'] , 'video'))){
				return $this->sendEx($message , $res['data']->ssvid);
			}else{
				$response['objID'] = $objID;
                $response['seq'] = $message['seq'];
				$response['mediaInfoList'] = array();

				$res['data'] = $returnResult;
				$objectType = $this->checkObjectType($res['data']);
				$router = $this->domian->getObjectRouter($objID);
				if($router['status'] === 0){
					$ip = !empty($router['data']->IASIP) ? $router['data']->IASIP : "";
					$port = !empty($router['data']->IASPort) ? $router['data']->IASPort : "";
					$IAS = $this->domian->getIAShandle($ip , $port);
					if(!$IAS){
						$message['sendFlag'] = 252;
						$this->SaveCommands($message);
						return $this->jsonResponse(Api_Define::$ROUTE_ISNULL['status'], Api_Define::$ROUTE_ISNULL['info']);
					}
					$cmdInfo['objId'] = $objID;
					if(!empty($res['data']->Protocol) && $res['data']->Protocol == "BB_808"){
						if(!empty($res['data']->IMEI)){
							$len = strlen($res['data']->IMEI);
							if($len > 11){
								$res['data']->IMEI = substr($res['data']->IMEI , 4);
								$len = strlen($res['data']->IMEI);
							}
							if($len < 12){
								$res['data']->IMEI = sprintf('%012s', $res['data']->IMEI);
							}
							$cmdInfo['imei'] = $res['data']->IMEI;
						}else{
							$cmdInfo['imei'] = "";
						}
					}else{
						$cmdInfo['imei'] = !empty($res['data']->IMEI) ? $res['data']->IMEI : "";
					}
					$cmdInfo['factory'] = !empty($res['data']->Factory) ? $res['data']->Factory : "";
					$cmdInfo['brand'] = !empty($res['data']->Brand) ? $res['data']->Brand : "";
					$cmdInfo['protocol'] = !empty($res['data']->Protocol) ? $res['data']->Protocol : "";
                    if(stristr($message['sendContent'] , 'image') || stristr($message['sendContent'] , 'video')){
                        $m1 = explode(',' , $message['sendContent']);
                        if(count($m1) == 3 || count($m1) == 5){
                            $message['seq'] = $m1[1];
                        }else{
                            $m2[] = $message['seq'];
                            array_splice($m1,1,0,$m2);
                        }
                        $cmdInfo['content'] = implode(',' , $m1);
                    }else{
                        $cmdInfo['content'] = $message['sendContent'];
                    }
					$pack = $this->domian->packs($cmdInfo);
					if($pack['status'] === 0){
						$string = "";
						foreach($pack['data'] as $v){
							$string .= chr($v);
						}
						$cmd['SequenceNo'] = time();
						$cmd['Imei'] = $cmdInfo['imei'];
						$cmd['Content'] = $string;
						$md5String = 'SequenceNo:'. $cmd['SequenceNo'] .',Imei:' . $cmd['Imei'] . ',rYRYU54QUSGF562e3dwc3eT,Content:' . $cmd['Content'];
						$cmd['Digest'] = md5($md5String);
						$send = $this->domian->pushCmd($IAS , $cmd);
						if($send === 0){
							$message['sendFlag'] = 0;
                            $this->SaveCommands($message);
                            if($res['data']->MDTTypeID == 199){
                                $c = explode(',' , $message['sendContent']);
                                if(count($c) >= 4 && $c[0] == 'Track' && $c[1] == 1){
                                    $param['delay'] = (int)($c[3] * 60);
                                    $param['scheduledTime'] = time() + $param['delay'];
                                    $param['taskInfo'] = json_encode([
                                        "type" => 0,
                                        "objId" => $objID,
                                        "imei" => $res['data']->IMEI,
                                        "protocol" => $cmdInfo['protocol'],
                                        "brand" => $cmdInfo['brand'],
                                        "factory" => $cmdInfo['factory'],
                                        "content" => 'Track,0,0,0'
                                    ]);
                                    $r = $this->domian->addTaskInfo($param);
                                }
                            }
							return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'] , $response);
						}else{
							$message['sendFlag'] = 252;
							$res = $this->SaveCommands($message);
							return $this->jsonResponse(Api_Define::$RETURN_FALL['status'], Api_Define::$RETURN_FALL['info'] , $res);
						}
					}else{
						$message['sendFlag'] = 252;
						$res = $this->SaveCommands($message);
						return $this->jsonResponse(Api_Define::$CODING_FALL['status'], Api_Define::$CODING_FALL['info'] , $res);
					}
				}else{
					if(empty($res['data']->IsWireless)){
						$message['sendFlag'] = 255;
					}else{
						$message['sendFlag'] = 254;
					}
					$res = $this->SaveCommands($message);
					if($res === 0){
						if($objectType == "cdb"){
							return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'] , $response);
						}else{
							return $this->jsonResponse(Api_Define::$RETURN_SEND_IN['status'], Api_Define::$RETURN_SEND_IN['info'] , $res);
						}
					}else{
						return $this->jsonResponse(Api_Define::$RETURN_FALL['status'], Api_Define::$RETURN_FALL['info']."DB" , $res);
					}
				}
			}
		}else{
			return $this->jsonResponse(Api_Define::$RETURN_NOT_FOUND['status'], Api_Define::$RETURN_NOT_FOUND['info']);
		}
    }
	public function sendEx($message = array() , $deviceId = 0){
		$content = explode(",",$this->request['content']);
		$type = !empty($content[0]) ? ($content[0] == 'Image' ? 1 : 2) : 0;
		$end = substr($content[count($content)-1], -4);
		$param = array(
			'deviceId' => (string)$deviceId,
			'width' => $type == 2 ? 640 : 480 ,
			'height'=> $type == 2 ? 360 : 270 ,
			'cameratype' => (int)substr($end, -2)
		);
		if($type == 1){
			$param['count'] = intval($content[2]);
			$param['interval'] = (int)substr($end, 0 , 2);
		}else if($type == 2){
			$param['fps'] = 200;
			$param['duration'] = (int)substr($end, 0 , 2);
		}
		$res = $this->domian->TakeCmd($param , $type);
		if($res['status'] === 0){
			$message['sendFlag'] = 0;
			$rep['objID'] = $message['ObjectID'];
			$message['seq'] = $rep['seq'] = $res['seq'];
			$rep['mediaInfoList'] = array();
			foreach($res['info'] as $key=>$val){
				$rep['mediaInfoList'][$key]['type'] = $val->type;
				$rep['mediaInfoList'][$key]['url'] = $val->url;
				$rep['mediaInfoList'][$key]['position']['lat'] = !empty($val->position->point->lat) ? number_format($val->position->point->lat / 1000000.0, 6) : 0;
				$rep['mediaInfoList'][$key]['position']['lng'] = !empty($val->position->point->lng) ? number_format($val->position->point->lng / 1000000.0, 6) : 0;
				$rep['mediaInfoList'][$key]['position']['gpstime'] = isset($val->position->gpsTime) ? date('Y-m-d H:i:s', $val->position->gpsTime) : '';
				$rep['mediaInfoList'][$key]['position']['speed'] = !empty($val->position->speed) ? $val->position->speed : 0;
				$rep['mediaInfoList'][$key]['position']['direct'] = !empty($val->position->direction) ? $val->position->direction : 0;
			}
			$res = $this->SaveCommands($message);
			return $this->jsonResponse(Api_Define::$RETURN_SUCCESS['status'], Api_Define::$RETURN_SUCCESS['info'] , $rep);
		}else{
			$message['sendFlag'] = 252;
			$res = $this->SaveCommands($message);
			return $this->jsonResponse(Api_Define::$RETURN_FALL['status'], Api_Define::$RETURN_FALL['info'] , $res);
		}
	}
	private function saveCommands($message = array()){
		if(empty($message))return -10;
		$i = 0;
		//重试3次
		while($i < 3){
			$status = $this->domian->SaveCommands($message);
			if($status === 0)break;
			$i++;
		}
		return $status;
	}

	private function checkObjectType($object){
		if($object->Brand == "后视镜" && $object->Protocol == "MG_1.0" && $object->Factory == "MG"){
			return "znml";
		}else{
			return "cdb";
		}
	}

	private function createUUID($prefix = ""){
        list($s1, $s2) = explode(' ', microtime());
		return (string)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
		$str = md5(uniqid(mt_rand(), true));   
		$uuid  = substr($str,0,8);   
		$uuid .= substr($str,8,4);   
		$uuid .= substr($str,12,4);   
		$uuid .= substr($str,16,4);   
		$uuid .= substr($str,20,12);   
		return strtoupper($prefix . $uuid);
	}
}