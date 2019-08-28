<?php
// **********************************************************************
//
// Copyright (c) 2003-2016 ZeroC, Inc. All rights reserved.
//
// This copy of Ice is licensed to you under the terms described in the
// ICE_LICENSE file included in this distribution.
//
// **********************************************************************
//
// Ice version 3.6.3
//
// <auto-generated>
//
// Generated from file `DataStructs.ice'
//
// Warning: do not edit this file.
//
// </auto-generated>
//

require_once 'Ice/BuiltinSequences.php';

global $DataStructs__t_DevId;

if(!class_exists('DataStructs_DevId'))
{
    class DataStructs_DevId
    {
        public function __construct($app="", $imei="")
        {
            $this->app = $app;
            $this->imei = $imei;
        }

        public function __toString()
        {
            global $DataStructs__t_DevId;
            return IcePHP_stringify($this, $DataStructs__t_DevId);
        }

        public $app;
        public $imei;
    }

    $DataStructs__t_DevId = IcePHP_defineStruct('::DataStructs::DevId', 'DataStructs_DevId', array(
        array('app', $IcePHP__t_string), 
        array('imei', $IcePHP__t_string)));
}

global $DataStructs__t_DevIdSeq;

if(!isset($DataStructs__t_DevIdSeq))
{
    $DataStructs__t_DevIdSeq = IcePHP_defineSequence('::DataStructs::DevIdSeq', $DataStructs__t_DevId);
}

global $DataStructs__t_GeoPoint;

if(!class_exists('DataStructs_GeoPoint'))
{
    class DataStructs_GeoPoint
    {
        public function __construct($lng=0, $lat=0)
        {
            $this->lng = $lng;
            $this->lat = $lat;
        }

        public function __toString()
        {
            global $DataStructs__t_GeoPoint;
            return IcePHP_stringify($this, $DataStructs__t_GeoPoint);
        }

        public $lng;
        public $lat;
    }

    $DataStructs__t_GeoPoint = IcePHP_defineStruct('::DataStructs::GeoPoint', 'DataStructs_GeoPoint', array(
        array('lng', $IcePHP__t_int), 
        array('lat', $IcePHP__t_int)));
}

global $DataStructs__t_GeoPointSeq;

if(!isset($DataStructs__t_GeoPointSeq))
{
    $DataStructs__t_GeoPointSeq = IcePHP_defineSequence('::DataStructs::GeoPointSeq', $DataStructs__t_GeoPoint);
}

global $DataStructs__t_AdminRegion;

if(!class_exists('DataStructs_AdminRegion'))
{
    class DataStructs_AdminRegion
    {
        public function __construct($province="", $city="", $region="")
        {
            $this->province = $province;
            $this->city = $city;
            $this->region = $region;
        }

        public function __toString()
        {
            global $DataStructs__t_AdminRegion;
            return IcePHP_stringify($this, $DataStructs__t_AdminRegion);
        }

        public $province;
        public $city;
        public $region;
    }

    $DataStructs__t_AdminRegion = IcePHP_defineStruct('::DataStructs::AdminRegion', 'DataStructs_AdminRegion', array(
        array('province', $IcePHP__t_string), 
        array('city', $IcePHP__t_string), 
        array('region', $IcePHP__t_string)));
}

global $DataStructs__t_GPSData;

if(!class_exists('DataStructs_GPSData'))
{
    class DataStructs_GPSData
    {
        public function __construct($gpsTime=0, $rcvTime=0, $point=null, $mileage=0, $speed=0, $direction=0, $altitude=0, $battery=0, $messageType=0, $gsmStrength=0, $satelliteNum=0, $gpsAccuracyType=0, $alarmFlag=false, $alarmType="", $alarmDesc="")
        {
            $this->gpsTime = $gpsTime;
            $this->rcvTime = $rcvTime;
            $this->point = is_null($point) ? new DataStructs_GeoPoint : $point;
            $this->mileage = $mileage;
            $this->speed = $speed;
            $this->direction = $direction;
            $this->altitude = $altitude;
            $this->battery = $battery;
            $this->messageType = $messageType;
            $this->gsmStrength = $gsmStrength;
            $this->satelliteNum = $satelliteNum;
            $this->gpsAccuracyType = $gpsAccuracyType;
            $this->alarmFlag = $alarmFlag;
            $this->alarmType = $alarmType;
            $this->alarmDesc = $alarmDesc;
        }

        public function __toString()
        {
            global $DataStructs__t_GPSData;
            return IcePHP_stringify($this, $DataStructs__t_GPSData);
        }

        public $gpsTime;
        public $rcvTime;
        public $point;
        public $mileage;
        public $speed;
        public $direction;
        public $altitude;
        public $battery;
        public $messageType;
        public $gsmStrength;
        public $satelliteNum;
        public $gpsAccuracyType;
        public $alarmFlag;
        public $alarmType;
        public $alarmDesc;
    }

    $DataStructs__t_GPSData = IcePHP_defineStruct('::DataStructs::GPSData', 'DataStructs_GPSData', array(
        array('gpsTime', $IcePHP__t_int), 
        array('rcvTime', $IcePHP__t_int), 
        array('point', $DataStructs__t_GeoPoint), 
        array('mileage', $IcePHP__t_int), 
        array('speed', $IcePHP__t_short), 
        array('direction', $IcePHP__t_short), 
        array('altitude', $IcePHP__t_short), 
        array('battery', $IcePHP__t_byte), 
        array('messageType', $IcePHP__t_byte), 
        array('gsmStrength', $IcePHP__t_byte), 
        array('satelliteNum', $IcePHP__t_byte), 
        array('gpsAccuracyType', $IcePHP__t_byte), 
        array('alarmFlag', $IcePHP__t_bool), 
        array('alarmType', $IcePHP__t_string), 
        array('alarmDesc', $IcePHP__t_string)));
}

global $DataStructs__t_GPSDataSeq;

if(!isset($DataStructs__t_GPSDataSeq))
{
    $DataStructs__t_GPSDataSeq = IcePHP_defineSequence('::DataStructs::GPSDataSeq', $DataStructs__t_GPSData);
}

global $DataStructs__t_GPSDataEx;

if(!class_exists('DataStructs_GPSDataEx'))
{
    class DataStructs_GPSDataEx
    {
        public function __construct($gpsData=null, $adminRegion=null)
        {
            $this->gpsData = is_null($gpsData) ? new DataStructs_GPSData : $gpsData;
            $this->adminRegion = is_null($adminRegion) ? new DataStructs_AdminRegion : $adminRegion;
        }

        public function __toString()
        {
            global $DataStructs__t_GPSDataEx;
            return IcePHP_stringify($this, $DataStructs__t_GPSDataEx);
        }

        public $gpsData;
        public $adminRegion;
    }

    $DataStructs__t_GPSDataEx = IcePHP_defineStruct('::DataStructs::GPSDataEx', 'DataStructs_GPSDataEx', array(
        array('gpsData', $DataStructs__t_GPSData), 
        array('adminRegion', $DataStructs__t_AdminRegion)));
}

global $DataStructs__t_GPSDataExSeq;

if(!isset($DataStructs__t_GPSDataExSeq))
{
    $DataStructs__t_GPSDataExSeq = IcePHP_defineSequence('::DataStructs::GPSDataExSeq', $DataStructs__t_GPSDataEx);
}

global $DataStructs__t_GPSDataOpt;
global $DataStructs__t_GPSDataOptPrx;

if(!class_exists('DataStructs_GPSDataOpt'))
{
    class DataStructs_GPSDataOpt extends Ice_ObjectImpl
    {
        public function __construct($gpsTime=Ice_Unset, $rcvTime=Ice_Unset, $point=Ice_Unset, $mileage=Ice_Unset, $speed=Ice_Unset, $direction=Ice_Unset, $altitude=Ice_Unset, $battery=Ice_Unset, $messageType=Ice_Unset, $gsmStrength=Ice_Unset, $satelliteNum=Ice_Unset, $gpsAccuracyType=Ice_Unset, $theDayInitMileage=Ice_Unset, $statusDesc=Ice_Unset)
        {
            $this->gpsTime = $gpsTime;
            $this->rcvTime = $rcvTime;
            $this->point = is_null($point) ? new DataStructs_GeoPoint : $point;
            $this->mileage = $mileage;
            $this->speed = $speed;
            $this->direction = $direction;
            $this->altitude = $altitude;
            $this->battery = $battery;
            $this->messageType = $messageType;
            $this->gsmStrength = $gsmStrength;
            $this->satelliteNum = $satelliteNum;
            $this->gpsAccuracyType = $gpsAccuracyType;
            $this->theDayInitMileage = $theDayInitMileage;
            $this->statusDesc = $statusDesc;
        }

        public static function ice_staticId()
        {
            return '::DataStructs::GPSDataOpt';
        }

        public function __toString()
        {
            global $DataStructs__t_GPSDataOpt;
            return IcePHP_stringify($this, $DataStructs__t_GPSDataOpt);
        }

        public $gpsTime;
        public $rcvTime;
        public $point;
        public $mileage;
        public $speed;
        public $direction;
        public $altitude;
        public $battery;
        public $messageType;
        public $gsmStrength;
        public $satelliteNum;
        public $gpsAccuracyType;
        public $theDayInitMileage;
        public $statusDesc;
    }

    class DataStructs_GPSDataOptPrxHelper
    {
        public static function checkedCast($proxy, $facetOrCtx=null, $ctx=null)
        {
            return $proxy->ice_checkedCast('::DataStructs::GPSDataOpt', $facetOrCtx, $ctx);
        }

        public static function uncheckedCast($proxy, $facet=null)
        {
            return $proxy->ice_uncheckedCast('::DataStructs::GPSDataOpt', $facet);
        }

        public static function ice_staticId()
        {
            return '::DataStructs::GPSDataOpt';
        }
    }

    $DataStructs__t_GPSDataOpt = IcePHP_defineClass('::DataStructs::GPSDataOpt', 'DataStructs_GPSDataOpt', -1, false, false, $Ice__t_Object, null, array(
        array('gpsTime', $IcePHP__t_int, true, 1),
        array('rcvTime', $IcePHP__t_int, true, 2),
        array('point', $DataStructs__t_GeoPoint, true, 3),
        array('mileage', $IcePHP__t_int, true, 4),
        array('speed', $IcePHP__t_short, true, 5),
        array('direction', $IcePHP__t_short, true, 6),
        array('altitude', $IcePHP__t_short, true, 7),
        array('battery', $IcePHP__t_byte, true, 8),
        array('messageType', $IcePHP__t_byte, true, 9),
        array('gsmStrength', $IcePHP__t_byte, true, 10),
        array('satelliteNum', $IcePHP__t_byte, true, 11),
        array('gpsAccuracyType', $IcePHP__t_byte, true, 12),
        array('theDayInitMileage', $IcePHP__t_int, true, 13),
        array('statusDesc', $IcePHP__t_string, true, 14)));

    $DataStructs__t_GPSDataOptPrx = IcePHP_defineProxy($DataStructs__t_GPSDataOpt);
}

global $DataStructs__t_GPSRecord;

if(!class_exists('DataStructs_GPSRecord'))
{
    class DataStructs_GPSRecord
    {
        public function __construct($objId=0, $gpsDataEx=null)
        {
            $this->objId = $objId;
            $this->gpsDataEx = is_null($gpsDataEx) ? new DataStructs_GPSDataEx : $gpsDataEx;
        }

        public function __toString()
        {
            global $DataStructs__t_GPSRecord;
            return IcePHP_stringify($this, $DataStructs__t_GPSRecord);
        }

        public $objId;
        public $gpsDataEx;
    }

    $DataStructs__t_GPSRecord = IcePHP_defineStruct('::DataStructs::GPSRecord', 'DataStructs_GPSRecord', array(
        array('objId', $IcePHP__t_int), 
        array('gpsDataEx', $DataStructs__t_GPSDataEx)));
}

global $DataStructs__t_GPSRecordSeq;

if(!isset($DataStructs__t_GPSRecordSeq))
{
    $DataStructs__t_GPSRecordSeq = IcePHP_defineSequence('::DataStructs::GPSRecordSeq', $DataStructs__t_GPSRecord);
}

global $DataStructs__t_GPSDataSimple;

if(!class_exists('DataStructs_GPSDataSimple'))
{
    class DataStructs_GPSDataSimple
    {
        public function __construct($gpsTime=0, $rcvTime=0, $point=null, $mileage=0, $speed=0, $direction=0)
        {
            $this->gpsTime = $gpsTime;
            $this->rcvTime = $rcvTime;
            $this->point = is_null($point) ? new DataStructs_GeoPoint : $point;
            $this->mileage = $mileage;
            $this->speed = $speed;
            $this->direction = $direction;
        }

        public function __toString()
        {
            global $DataStructs__t_GPSDataSimple;
            return IcePHP_stringify($this, $DataStructs__t_GPSDataSimple);
        }

        public $gpsTime;
        public $rcvTime;
        public $point;
        public $mileage;
        public $speed;
        public $direction;
    }

    $DataStructs__t_GPSDataSimple = IcePHP_defineStruct('::DataStructs::GPSDataSimple', 'DataStructs_GPSDataSimple', array(
        array('gpsTime', $IcePHP__t_int), 
        array('rcvTime', $IcePHP__t_int), 
        array('point', $DataStructs__t_GeoPoint), 
        array('mileage', $IcePHP__t_int), 
        array('speed', $IcePHP__t_short), 
        array('direction', $IcePHP__t_short)));
}

global $DataStructs__t_TravelInfo;

if(!class_exists('DataStructs_TravelInfo'))
{
    class DataStructs_TravelInfo
    {
        public function __construct($travelId=0, $isCompleted=true, $startPos=null, $stopPos=null, $travelMileage=0, $travelOil=0, $travelPeriod=0, $drivePeriod=0, $overSpeedCount=0, $celerateCount=0, $decelerateCount=0, $stopACCOnCount=0, $startFlag=0, $stopFlag=0, $startEventId=0, $stopEventId=0, $stayId=0, $remark="", $seqFaultCode=null)
        {
            $this->travelId = $travelId;
            $this->isCompleted = $isCompleted;
            $this->startPos = is_null($startPos) ? new DataStructs_GPSDataSimple : $startPos;
            $this->stopPos = is_null($stopPos) ? new DataStructs_GPSDataSimple : $stopPos;
            $this->travelMileage = $travelMileage;
            $this->travelOil = $travelOil;
            $this->travelPeriod = $travelPeriod;
            $this->drivePeriod = $drivePeriod;
            $this->overSpeedCount = $overSpeedCount;
            $this->celerateCount = $celerateCount;
            $this->decelerateCount = $decelerateCount;
            $this->stopACCOnCount = $stopACCOnCount;
            $this->startFlag = $startFlag;
            $this->stopFlag = $stopFlag;
            $this->startEventId = $startEventId;
            $this->stopEventId = $stopEventId;
            $this->stayId = $stayId;
            $this->remark = $remark;
            $this->seqFaultCode = $seqFaultCode;
        }

        public function __toString()
        {
            global $DataStructs__t_TravelInfo;
            return IcePHP_stringify($this, $DataStructs__t_TravelInfo);
        }

        public $travelId;
        public $isCompleted;
        public $startPos;
        public $stopPos;
        public $travelMileage;
        public $travelOil;
        public $travelPeriod;
        public $drivePeriod;
        public $overSpeedCount;
        public $celerateCount;
        public $decelerateCount;
        public $stopACCOnCount;
        public $startFlag;
        public $stopFlag;
        public $startEventId;
        public $stopEventId;
        public $stayId;
        public $remark;
        public $seqFaultCode;
    }

    $DataStructs__t_TravelInfo = IcePHP_defineStruct('::DataStructs::TravelInfo', 'DataStructs_TravelInfo', array(
        array('travelId', $IcePHP__t_long), 
        array('isCompleted', $IcePHP__t_bool), 
        array('startPos', $DataStructs__t_GPSDataSimple), 
        array('stopPos', $DataStructs__t_GPSDataSimple), 
        array('travelMileage', $IcePHP__t_int), 
        array('travelOil', $IcePHP__t_int), 
        array('travelPeriod', $IcePHP__t_int), 
        array('drivePeriod', $IcePHP__t_int), 
        array('overSpeedCount', $IcePHP__t_int), 
        array('celerateCount', $IcePHP__t_int), 
        array('decelerateCount', $IcePHP__t_int), 
        array('stopACCOnCount', $IcePHP__t_int), 
        array('startFlag', $IcePHP__t_int), 
        array('stopFlag', $IcePHP__t_int), 
        array('startEventId', $IcePHP__t_long), 
        array('stopEventId', $IcePHP__t_long), 
        array('stayId', $IcePHP__t_long), 
        array('remark', $IcePHP__t_string), 
        array('seqFaultCode', $Ice__t_StringSeq)));
}

global $DataStructs__t_TravelInfoSeq;

if(!isset($DataStructs__t_TravelInfoSeq))
{
    $DataStructs__t_TravelInfoSeq = IcePHP_defineSequence('::DataStructs::TravelInfoSeq', $DataStructs__t_TravelInfo);
}

global $DataStructs__t_Alarm;

if(!class_exists('DataStructs_Alarm'))
{
    class DataStructs_Alarm
    {
        public function __construct($id=0, $objId=0, $type=0, $createTime=0, $edOrCpId=0, $lng=0, $lat=0, $speed=0, $direction=0, $gpsAccuracyType=0, $gpsTime=0, $alarmFlag=false, $alarmType="", $alarmDesc="")
        {
            $this->id = $id;
            $this->objId = $objId;
            $this->type = $type;
            $this->createTime = $createTime;
            $this->edOrCpId = $edOrCpId;
            $this->lng = $lng;
            $this->lat = $lat;
            $this->speed = $speed;
            $this->direction = $direction;
            $this->gpsAccuracyType = $gpsAccuracyType;
            $this->gpsTime = $gpsTime;
            $this->alarmFlag = $alarmFlag;
            $this->alarmType = $alarmType;
            $this->alarmDesc = $alarmDesc;
        }

        public function __toString()
        {
            global $DataStructs__t_Alarm;
            return IcePHP_stringify($this, $DataStructs__t_Alarm);
        }

        public $id;
        public $objId;
        public $type;
        public $createTime;
        public $edOrCpId;
        public $lng;
        public $lat;
        public $speed;
        public $direction;
        public $gpsAccuracyType;
        public $gpsTime;
        public $alarmFlag;
        public $alarmType;
        public $alarmDesc;
    }

    $DataStructs__t_Alarm = IcePHP_defineStruct('::DataStructs::Alarm', 'DataStructs_Alarm', array(
        array('id', $IcePHP__t_long), 
        array('objId', $IcePHP__t_int), 
        array('type', $IcePHP__t_int), 
        array('createTime', $IcePHP__t_int), 
        array('edOrCpId', $IcePHP__t_int), 
        array('lng', $IcePHP__t_int), 
        array('lat', $IcePHP__t_int), 
        array('speed', $IcePHP__t_int), 
        array('direction', $IcePHP__t_int), 
        array('gpsAccuracyType', $IcePHP__t_int), 
        array('gpsTime', $IcePHP__t_int), 
        array('alarmFlag', $IcePHP__t_bool), 
        array('alarmType', $IcePHP__t_string), 
        array('alarmDesc', $IcePHP__t_string)));
}

global $DataStructs__t_AlarmSeq;

if(!isset($DataStructs__t_AlarmSeq))
{
    $DataStructs__t_AlarmSeq = IcePHP_defineSequence('::DataStructs::AlarmSeq', $DataStructs__t_Alarm);
}
?>
