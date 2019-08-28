<?php

/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2017/4/6
 * Time: 15:21
 * Email: 1183@mapgoo.net
 */
class Api_Alarm
{	
    //获取系统状态
	public static function getSysDec($sys){
		$SysDes = array(
			64=>'发动机（熄火/启动）', 
			65=>'非法移动状态', 
			66=>'超速状态',
			67=>'行政区外状态', 
			68=>'在二押点内状态', 
			69=>'疑似屏蔽状态',
			//20161214新增
			70=>'在二押点内停留告警',
			71=>'在二押点内久留告警',
			128=>'进围栏告警',
			129=>'出围栏告警'
		);
		return !empty($SysDes[$sys])?$SysDes[$sys]:"";
	}
	public static function getSysEvent($sys){
		$SysEvent = array(
			0=>'SOS报警开始', 
			1=>'SOS报警结束', 
			2=>'盗警报警开始', 
			3=>'盗警报警结束', 
			4=>'断电报警开始', 
			5=>'断电报警结束', 
			6=>'震动报警开始', 
			7=>'震动报警结束', 
			8=>'低电压报警开始', 
			9=>'低电压报警结束', 
			10=>'开盖报警开始', 
			11=>'开盖报警结束', 
			12=>'疲劳驾驶报警开始', 
			13=>'疲劳驾驶报警结束', 
			14=>'停车超时报警开始', 
			15=>'停车超时报警结束', 
			16=>'停车休息时间不足报警开始', 
			17=>'停车休息时间不足报警结束', 
			18=>'满电报警开始', 
			19=>'满电报警结束', 
			20=>'OBD故障开始', 
			21=>'OBD故障结束', 
			22=>'后备电池供电报警开始', 
			23=>'后备电池供电报警结束', 
			24=>'停车未熄火报警开始', 
			25=>'停车未熄火报警结束', 
			26=>'急加速报警开始', 
			27=>'急加速报警结束', 
			28=>'急减速报警开始', 
			29=>'急减速报警结束', 
			30=>'冷却液高温报警开始', 
			31=>'冷却液高温报警结束', 
			32=>'暗锁报警开始', 
			33=>'暗锁报警结束', 
			34=>'推车报警开始', 
			35=>'推车报警结束', 
			36=>'脱落报警开始', 
			37=>'脱落报警结束', 
			38=>'拆除报警开始', 
			39=>'拆除报警结束', 
			40=>'碰撞报警开始', 
			41=>'碰撞报警结束', 
			42=>'跌倒报警开始', 
			43=>'跌倒报警结束',
			128=>'启动开始',
			129=>'启动结束', 
			//20161214新增 
			130=>'非法移动报警开始', 
			131=>'非法移动报警结束', 
			132=>'超速报警开始', 
			133=>'超速报警结束', 
			134=>'出归属行政区报警开始', 
			135=>'出归属行政区报警结束', 
			136=>'进二押点报警开始', 
			137=>'进二押点报警结束', 
			138=>'疑似屏蔽报警开始', 
			139=>'疑似屏蔽报警结束',
			//20161214新增
			140=>'在二押点内停留告警开始',
			141=>'在二押点内停留告警结束',
			142=>'在二押点内久留告警开始',
			143=>'在二押点内久留告警结束',

			256=>'进围栏报警开始',
			257=>'进围栏报警结束',
			258=>'出围栏报警开始',
			259=>'出围栏报警结束'

		);
		return !empty($SysEvent[$sys])?$SysEvent[$sys]:"";
	}
	public static function getAlarmEvent($sys){
		$alarmEvent = array(
			0=>1000, 
			1=>1001, 
			2=>1002, 
			3=>1003,
			4=>1006, 
			5=>1007, 
			6=>1032, 
			7=>1044, 
			8=>1045, 
			9=>1053, 
			10=>1077, 
			11=>1082, 
			12=>1083, 
			13=>1084, 
			14=>1085, 
			15=>1086, 
			16=>1087, 
			17=>1095, 
			18=>1110, 
			19=>1116, 
			20=>1004, 
			21=>1014,
			48=>1092, 
			49=>1090, 
			50=>1100, 
			51=>1107, 
			52=>1094,
			65=>1050,
			66=>1051,
			67=>1056,
			68=>1111,
			69=>1117,
			70=>1112,
			71=>1113,
			128=>1040,
			129=>1041
        );
		return !empty($alarmEvent[$sys])?$alarmEvent[$sys]:"";
	}
	public static function getMdtStatus($sys){
		$MDTStatusTable = array(
			"1000" => "SOS",
			"1001" => "盗警",
			"1002" => "断电",
			"1003" => "震动",
			"1004" => "碰撞",
			"1005" => "低油量",
			"1006" => "低电压",
			"1007" => "开盖",
			"1010" => "非法开车门",
			"1011" => "非法启动",
			"1012" => "位移",
			"1013" => "超速",
			"1014" => "跌倒",
			"1015" => "最大载重",
			"1016" => "进范围",
			"1017" => "出范围",
			"1020" => "低温",
			"1021" => "高温",
			"1022" => "油量上升异常",
			"1023" => "油量下降异常",
			"1024" => "温度异常上升",
			"1025" => "温度异常下降",
			"1026" => "油量异常",
			"1027" => "温度异常",
			"1030" => "长时间非精确定位",
			"1031" => "线段分段限速",
			"1032" => "疲劳驾驶",
			"1033" => "非法时间段行驶",
			"1034" => "偏离线路",
			"1035" => "进站",
			"1036" => "出站",
			"1037" => "越站",
			"1040" => "进围栏",
			"1041" => "出围栏",
			"1042" => "区域内超速",
			"1043" => "区域内低速",
			"1044" => "停车超时",
			"1045" => "停车休息时间不足",
			"1046" => "胎压异常",
			"1047" => "载重变化",
			"1050" => "非法移动",
			"1051" => "超速",
			"1052" => "离线提醒",
			"1053" => "满电提醒",
			"1054" => "上线提醒",
			"1055" => "进行政区域",
			"1056" => "出行政区域",
			"1057" => "CAN通讯故障",
			"1060" => "天线短路",
			"1061" => "天线断路",
			"1062" => "总线故障",
			"1063" => "GPS定位模块故障",
			"1064" => "GSM通讯模块故障",
			"1065" => "ACC线故障",
			"1066" => "报警器断电",
			"1067" => "设备已见光",
			"1070" => "锁车电路故障",
			"1071" => "后备电池异常",
			"1072" => "LCD故障",
			"1073" => "内存状态异常",
			"1074" => "FLASH状态异常",
			"1075" => "SD卡状态异常",
			"1076" => "CPU状态异常",
			"1077" => "OBD故障",
			"1080" => "摄像头连接状态异常",
			"1081" => "IC卡连接状态异常",
			"1082" => "后备电池供电",
			"1083" => "停车未熄火",
			"1084" => "急加速告警",
			"1085" => "急减速告警",
			"1086" => "冷却液高温告警",
			"1087" => "暗锁",
			"1090" => "车门开",
			"1091" => "车辆设防",
			"1092" => "ACC关",
			"1093" => "重车",
			"1094" => "断油电状态",
			"1095" => "推车",
			"1096" => "卫星定位锁定",
			"1097" => "空调开",
			"1100" => "后尾箱开",
			"1101" => "右后门开",
			"1102" => "左后门开",
			"1103" => "右前门开",
			"1104" => "车大灯开",
			"1105" => "门锁关",
			"1106" => "左前门开",
			"1107" => "车窗开",
			"1110" => "脱落",
			"1111" => "进二押点",
			"1112" => "二押停留",
			"1113" => "二押久留",
			"1114" => "光感",
			"1115" => "磁感",
			"1116" => "拆除报警",
			//
			"1117" => "疑似屏蔽",
			"1120" => "长停上线提醒",
			"1130" => "反欺诈",
			"1121" => "上电提醒",
			"1122" => "GPS分离",
			"1123" => "聚集",
		);
		return !empty($MDTStatusTable[$sys])?$MDTStatusTable[$sys]:"";
	}
}