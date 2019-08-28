<?php 
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/22
 * Time: 11:07
 * Email: 1183@mapgoo.net
 */
class Api_Desc
{
	private static $statusDescDoorOpen = '门开';
    private static $statusDescDoorClose = '门关';
    private static $statusDescIgnition = '启动';
    private static $statusDescFlameout = '熄火';

    private static $altitudeFmt = '海拔%s.0米';
    private static $batteryFmt = '电量（%s%%）';
    private static $gsmStrengthFmt = 'GSM信号（%s）';
    private static $satelliteNumFmt = 'GPS卫星颗数（%s）';
    private static $beidouSateliteNumFmt = '北斗卫星颗数（%s）';
	private static $MessageTypeArray = array(
		1 => '登录',
        2 => '位置上报',
        3 => '待命',
        4 => 'OBD信息（实时PID）',
        5 => 'OBD信息（行程事件数据）',
        6 => 'OBD信息（实时行程数据）',
        7 => '警情上报',
		8 => '状态上报',
		9 => '下发指令回复',
		10 => '请求参数上报',
		11 => '请求信息',
		100 => '其他（扩展）'
    );
    public static $GPSAccuracyTypeArray = array(
		0 => '精确GPS',
        1 => '非精确GPS',
        2 => '基站',
        3 => 'wifi',
        4 => '第三方接口'
    );

    private static $gsmStrengthArray = array(
		1 => '极弱',
        2 => '较弱',
        3 => '一般',
        4 => '良好',
        5 => '强',
    );
	public static $comma = "，";
	public static function getStatusDesc($gpsDatas,$type = 0){
		if($type){
			$gpsDatas = (array)$gpsDatas;
			$gpsDatas['lng'] = $gpsDatas['point']->lng;
			$gpsDatas['lat'] = $gpsDatas['point']->lat;
			unset($gpsDatas['point']);
			$gpsDatas['mdtStatus'] = array();
		}
        $trackDesc[0] = self::getStatusMsg($gpsDatas['mdtStatus']);
        if ($gpsDatas['messageType'] && $gpsDatas['messageType'] > 0) {
            $trackDesc[1] = self::$MessageTypeArray[$gpsDatas['messageType']];
        }

        switch ($gpsDatas['messageType']) {
            case 6:
                break;  //OBD
            default:
                if ($gpsDatas['messageType'] == 2) {
                    $trackDesc[1] .= '（' . self::$GPSAccuracyTypeArray[$gpsDatas['gpsAccuracyType']] . '）';
                }

                if ($gpsDatas['battery'] && $gpsDatas['battery'] != 255) {
                    $trackDesc[] = sprintf(self::$batteryFmt, $gpsDatas['battery']);
                }

                if ($gpsDatas['gsmStrength'] && $gpsDatas['gsmStrength'] != 255) {
                    $trackDesc[] = sprintf(self::$gsmStrengthFmt, self::$gsmStrengthArray[$gpsDatas['gsmStrength']]);
                }

                if ($gpsDatas['satelliteNum'] && $gpsDatas['satelliteNum'] != 255 && $gpsDatas['gpsAccuracyType'] != 2) {
                    $trackDesc[] = sprintf(self::$satelliteNumFmt, $gpsDatas['satelliteNum']);
                }

                if ($gpsDatas['altitude']) {
                    $trackDesc[] = sprintf(self::$altitudeFmt, $gpsDatas['altitude']);
                }
                break;  //ohters
        }
        return implode(self::$comma,array_filter($trackDesc));
	}

	public static function getStatusDescMFS($gpsDatas){
        $trackDesc[0] = self::getStatusMsg($gpsDatas['mdtStatus']);
        if ($gpsDatas['messageType'] && $gpsDatas['messageType'] > 0) {
            $messageDesc = [];
            if($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_LOGIN){
                $messageDesc[] = '登录';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_LOCATION){
                $messageDesc[] = '启动'.self::$comma.'位置上报（' . self::$GPSAccuracyTypeArray[$gpsDatas['gpsAccuracyType']] . '）';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_HEARTBEAT){
                $messageDesc[] = '待命';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_OBD_PID){
                $messageDesc[] = 'OBD信息（实时PID）';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_OBD_TRAVEL_START_EVENT){
                $messageDesc[] = 'OBD信息（行程启动事件）';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_OBD_TRAVEL_STOP_EVENT){
                $messageDesc[] = 'OBD信息（行程熄火事件）';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_ODB_TRAVEL){
                $messageDesc[] = 'OBD信息（实时行程数据）';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_ALARM){
                $messageDesc[] = '警情上报';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_STATUS){
                $messageDesc[] = '状态上报';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_REPLY){
                $messageDesc[] = '下发指令回复';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_ARGS){
                $messageDesc[] = '请求参数上报';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_REQ_INFO){
                $messageDesc[] = '请求信息';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_CAR_RATE){
                $messageDesc[] = '车率数据';
            }
            if ($gpsDatas['messageType'] & \Mapgoo\Mfs\MessageType::MSG_TYPE_OTHER){
                $messageDesc[] = '其他（扩展）';
            }
            $trackDesc[1] = implode(self::$comma,$messageDesc);
        }
        if ($gpsDatas['battery'] && $gpsDatas['battery'] != 255) {
            $trackDesc[] = sprintf(self::$batteryFmt, $gpsDatas['battery']);
        }

        if ($gpsDatas['gsmStrength'] && $gpsDatas['gsmStrength'] != 255) {
            $trackDesc[] = sprintf(self::$gsmStrengthFmt, self::$gsmStrengthArray[$gpsDatas['gsmStrength']]);
        }

        if ($gpsDatas['satelliteNum'] && $gpsDatas['satelliteNum'] != 255 && $gpsDatas['gpsAccuracyType'] != 2) {
            $trackDesc[] = sprintf(self::$satelliteNumFmt, $gpsDatas['satelliteNum']);
        }
        if($gpsDatas['beidouSateliteNum'] && $gpsDatas['beidouSateliteNum'] != 255){
            $trackDesc[] = sprintf(self::$beidouSateliteNumFmt, $gpsDatas['beidouSateliteNum']);
        }
        if ($gpsDatas['altitude']) {
            $trackDesc[] = sprintf(self::$altitudeFmt, $gpsDatas['altitude']);
        }
        return implode(self::$comma,array_filter($trackDesc));
    }

	public static function getStatusMsg($mdtStatus = array()){
        $statusDesc = array();
        foreach($mdtStatus as $jBy=>$byteVal)
        {
            $bitMode = 1;
            for ($iBit = 0; $iBit < 8; ++$iBit, $bitMode = $bitMode << 1)    //bit num
            {
                $bitVal = $byteVal & $bitMode;

                if ($jBy == 9) {
                    if ($iBit == 0) {   //1090
                        if ($bitVal)
                            $statusDesc[] = self::$statusDescDoorOpen;
                        continue;
                    } else if ($iBit == 2) {   //1092
                        if (!$bitVal)
                            $statusDesc[] = self::$statusDescIgnition;
                        continue;
                    }
                }

                if ($bitVal) {
                    $statusKey = 1000 + $jBy * 10 + $iBit;
                    $Desc = Api_Alarm::getMdtStatus($statusKey);
                    if($Desc)$statusDesc[] = Api_Alarm::getMdtStatus($statusKey);
                }
            }
        }
        return $statusDesc ? implode(self::$comma,$statusDesc) : "";
	}
	/*public static function gsmStrength($gsmStrength){
		if ($gsmStrength > 0 && $gsmStrength <= 10) {
			$gsmStrength = 1;
		} else if ($gsmStrength > 10 && $gsmStrength <= 16) {
			$gsmStrength = 2;
		} else if ($gsmStrength > 16 && $gsmStrength <= 21) {
			$gsmStrength = 3;
		} else if ($gsmStrength > 21 && $gsmStrength <= 26) {
			$gsmStrength = 4;
		} else if ($gsmStrength > 26) {
			$gsmStrength = 5;
		}
		return $gsmStrength;
	}*/
}
?>