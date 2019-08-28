<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/14 16:55
 * Email: 1183@mapgoo.net
 */

namespace app\api\ice;


use mapgoo\helper\BytesHelper;
use Mapgoo\Mlb\M2maas\Request\Data\ResponseInfo;

class Bss
{
    /**
     * 设备修改响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function editTerminal($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getTerminalEditResp();
            if($object){
                $res['result']['iccid'] = $object->getIccid();
                $res['result']['effectiveDate'] = $object->getEffectiveDate();
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取设备内容响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getTerminalDetails($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetTerminalDetailResp();
            if($object){
                $res['result']['infos'] = [];
                foreach ($object->getInfosIterator() as $value) {
                    $info['iccid'] = $value->getIccid();
                    $info['terminalId'] = $value->getTerminalId();
                    $info['modemId'] = $value->getModemId();
                    $info['customer'] = $value->getCustomer();
                    $info['endConsumerId'] = $value->getEndConsumerId();
                    $info['suspended'] = $value->getSuspended();
                    $info['ratePlan'] = $value->getRatePlan();
                    $info['status'] = $value->getStatus();
                    $info['monthToDateUsage'] = $value->getMonthToDateUsage() ? round($value->getMonthToDateUsage() / 100, 2) : 0;
                    $info['overageLimitReached'] = $value->getOverageLimitReached();
                    $info['overageLimitOverride'] = $value->getOverageLimitOverride();
                    $info['dateActivated'] = $value->getDateActivated();
                    $info['dateAdded'] = $value->getDateAdded();
                    $info['dateModified'] = $value->getDateModified();
                    $info['dateShipped'] = $value->getDateShipped();
                    $info['monthToDateDataUsage'] = $value->getMonthToDateDataUsage() ? round($value->getMonthToDateDataUsage() / 100, 2) : 0;
                    $info['monthToDateSMSUsage'] = $value->getMonthToDateSMSUsage() ? round($value->getMonthToDateSMSUsage() / 100, 2) : 0;
                    $info['monthToDateVoiceUsage'] = $value->getMonthToDateVoiceUsage() ? round($value->getMonthToDateVoiceUsage() / 100, 2) : 0;
                    $info['secureSimId'] = $value->getSecureSimId();
                    $info['custom1'] = $value->getCustom1();
                    $info['custom2'] = $value->getCustom2();
                    $info['custom3'] = $value->getCustom3();
                    $info['custom4'] = $value->getCustom4();
                    $info['custom5'] = $value->getCustom5();
                    $info['custom6'] = $value->getCustom6();
                    $info['custom7'] = $value->getCustom7();
                    $info['custom8'] = $value->getCustom8();
                    $info['custom9'] = $value->getCustom9();
                    $info['custom10'] = $value->getCustom10();
                    $ratingInfo = $value->getRating();
                    if($ratingInfo){
                        $info['rating']['termStartDate'] = $ratingInfo->getTermStartDate();
                        $info['rating']['termEndDate'] = $ratingInfo->getTermEndDate();
                        $info['rating']['renewalPolicy'] = $ratingInfo->getTermEndDate();
                        $info['rating']['renewalRatePlan'] = $ratingInfo->getTermEndDate();
                        $info['rating']['totalPrimaryIncludedData'] = $ratingInfo->getTotalPrimaryIncludedData() ? round($ratingInfo->getTotalPrimaryIncludedData() / 100, 2) : 0;
                        $info['rating']['primaryDataRemaining'] = $ratingInfo->getPrimaryDataRemaining() ? round($ratingInfo->getPrimaryDataRemaining() / 100, 2) : 0;
                        $info['rating']['totalPrimaryIncludedSMS'] = $ratingInfo->getTotalPrimaryIncludedSMS() ? round($ratingInfo->getTotalPrimaryIncludedSMS() / 100, 2) : 0;
                        $info['rating']['primarySMSRemaining'] = $ratingInfo->getPrimarySMSRemaining() ? round($ratingInfo->getPrimarySMSRemaining() / 100, 2) : 0;
                    }
                    $info['secureSimUsernameCopyRule'] = $value->getSecureSimUsernameCopyRule();
                    $info['secureSimPasswordCopyRule'] = $value->getSecureSimPasswordCopyRule();
                    $info['accountId'] = $value->getAccountId();
                    $info['fixedIpAddress'] = $value->getFixedIpAddress();
                    $info['ctdSessionCount'] = $value->getCtdSessionCount();
                    $info['customerCustom1'] = $value->getCustomerCustom1();
                    $info['customerCustom2'] = $value->getCustomerCustom2();
                    $info['customerCustom3'] = $value->getCustomerCustom3();
                    $info['customerCustom4'] = $value->getCustomerCustom4();
                    $info['customerCustom5'] = $value->getCustomerCustom5();
                    $info['operatorCustom1'] = $value->getOperatorCustom1();
                    $info['operatorCustom2'] = $value->getOperatorCustom2();
                    $info['operatorCustom3'] = $value->getOperatorCustom3();
                    $info['operatorCustom4'] = $value->getOperatorCustom4();
                    $info['operatorCustom5'] = $value->getOperatorCustom5();
                    $info['imsi'] = $value->getImsi();
                    $info['primaryICCID'] = $value->getPrimaryICCID();
                    $info['imei'] = $value->getImei();
                    $info['globalSimType'] = $value->getGlobalSimType();
                    $info['simNotes'] = $value->getSimNotes();
                    $info['version'] = $value->getVersion();
                    $info['euiccid'] = $value->getEuiccid();
                    $info['msisdn'] = $value->getMsisdn();
                    $res['result']['infos'][] = $info;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 排队资费计划响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function queueTerminalRatePlan($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getQueueTerminalRatePlanResp();
            if($object){
                $res['result']['iccid'] = $object->getIccid();
                $res['result']['renewalRatePlan'] = $object->getRenewalRatePlan();
                $res['result']['status'] = $object->getStatus();
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 修改卡资费计划响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function editTerminalRating($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getEditTerminalRatingResp();
            if($object){
                $res['result']['iccid'] = $object->getIccid();
                $res['result']['status'] = $object->getStatus();
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取设备会话信息响应参数
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getSessionInfo($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetSessionInfoResp();
            if($object){
                $res['result']['sessionInfos'] = [];
                foreach ($object->getSessionInfosIterator() as $value){
                    $info['iccid'] = $value->getIccid();
                    $info['ipAddress'] = $value->getIpAddress();
                    $info['ipv6Address'] = $value->getIpv6Address();
                    $info['dateSessionStarted'] = $value->getDateSessionStarted();
                    $info['dateSessionEnded'] = $value->getDateSessionEnded();
                    $res['result']['sessionInfos'][] = $info;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取数据有变更过的卡响应参数
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getModifiedTerminals($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetModifiedTerminalsResp();
            if($object){
                $res['result']['totalPages'] = $object->getTotalPages();
                $res['result']['iccics'] = [];
                foreach ($object->getIccidsIterator() as $value){
                    $res['result']['iccics'][] = $value;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取基本资费计划和所有排队资费计划响应参数
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getTerminalRating($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetTerminalRatingResp();
            if($object){
                $res['result']['iccid'] = $object->getIccid();
                $res['result']['terminalRating'] = [];
                foreach ($object->getTerminalRatingIterator() as $value){
                    $info['ratePlanName'] = $value->getRatePlanName();
                    $info['queuePosition'] = $value->getQueuePosition();
                    $info['expirationDate'] = $value->getExpirationDate();
                    $info['termLength'] = $value->getTermLength();
                    $info['dataRemaining'] = $value->getDataRemaining() ? round($value->getDataRemaining() / 100, 2) : 0;
                    $res['result']['terminalRating'][] = $info;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取账单详情响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getTerminalAuditTrail($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetTerminalAuditTrailResp();
            if($object){
                $res['result']['totalPages'] = $object->getTotalPages();
                $res['result']['terminalAuditTrails'] = [];
                foreach ($object->getTerminalAuditTrailsIterator() as $value){
                    $info['field'] = $value->getField();
                    $info['priorValue'] = $value->getPriorValue();
                    $info['value'] = $value->getValue();
                    $info['effectiveDate'] = $value->getEffectiveDate();
                    $info['status'] = $value->getStatus();
                    $info['userName'] = $value->getUserName();
                    $info['delegatedUser'] = $value->getDelegatedUser();
                    $res['result']['terminalAuditTrails'][] = $info;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取设备当前的通讯网络配置响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getNetworkAccessConfig($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetNetworkAccessConfigResp();
            if($object){
                $res['result']['nacIds'] = [];
                foreach ($object->getNacIdsIterator() as $value){
                    $info['iccid'] = $value->getIccid();
                    $info['nacId'] = $value->getNacId();
                    $res['result']['nacIds'][] = $info;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 修改设备通信网络配置响应参数
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function editNetworkAccessConfig($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getEditNetworkAccessConfigResp();
            if($object){
                $res['result']['iccid'] = $object->getIccid();
                $res['result']['effectiveDate'] = $object->getEffectiveDate();
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取设备当前用量明细响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getTerminalUsageDataDetails($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetTerminalUsageDataDetailsResp();
            if($object){
                $res['result']['totalPages'] = $object->getTotalPages();
                foreach ($object->getUsageDetailsIterator() as $value){
                    $info['iccid'] = $value->getIccid();
                    $info['cycleStartDate'] = $value->getCycleStartDate();
                    $info['terminalId'] = $value->getTerminalId();
                    $info['endConsumerId'] = $value->getEndConsumerId();
                    $info['customer'] = $value->getCustomer();
                    $info['billable'] = $value->getBillable();
                    $info['zone'] = $value->getZone();
                    $info['sessionStartTime'] = $value->getSessionStartTime();
                    $info['duration'] = $value->getDuration();
                    $info['dataVolume'] = $value->getDataVolume() ? round($value->getDataVolume() / 100, 2) : 0;
                    $info['countryCode'] = $value->getCountryCode();
                    $info['serviceType'] = $value->getServiceType();
                    $res['result']['usageDetails'][] = $info;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 获取设备用量响应
     * @param $handle
     * @param $message
     * @return array|bool|int
     */
    public function getTerminalUsage($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getGetTerminalUsageResp();
            if($object){
                $res['result']['iccid'] = $object->getIccid();
                $res['result']['terminalId'] = $object->getTerminalId();
                $res['result']['customer'] = $object->getCustomer();
                $res['result']['endConsumerId'] = $object->getEndConsumerId();
                $res['result']['totalDataVolume'] = $object->getTotalDataVolume() ? round($object->getTotalDataVolume() / 100, 2) : 0;
                $res['result']['billableDataVolume'] = $object->getBillableDataVolume() ? round($object->getBillableDataVolume() / 100, 2) : 0;
                $res['result']['cycleStartDate'] = $object->getCycleStartDate();
                $res['result']['billable'] = $object->getBillable();
                $res['result']['totalSMSVolume'] = $object->getTotalSMSVolume() ? round($object->getTotalSMSVolume() / 100, 2) : 0;
                $res['result']['totalVoiceVolume'] = $object->getTotalVoiceVolume() ? round($object->getTotalVoiceVolume() / 100, 2) : 0;
                $res['result']['billableSMSVolume'] = $object->getBillableSMSVolume() ? round($object->getBillableSMSVolume() / 100, 2) : 0;
                $res['result']['billableVoiceVolume'] = $object->getBillableVoiceVolume() ? round($object->getBillableVoiceVolume() / 100, 2) : 0;
                $res['result']['ratePlan'] = $object->getRatePlan();
                $res['result']['eventsUsage'] = $object->getEventsUsage() ? round($object->getEventsUsage() / 100, 2) : 0;
                $res['result']['totalEvents'] = $object->getTotalEvents();
            }
            return $res;
        }else{
            return false;
        }
    }

    /**
     * 向一个设备发送短信响应
     * @param $handle
     * @param $message
     */
    public function sendSms($handle, $message)
    {
        $response = '';
        $res = $this->request($handle, $message, $response);
        if($res === 0){
            $response = BytesHelper::toStr($response);
            $resp = new ResponseInfo();
            $resp->parseFromString($response);
            $res = $this->baseInfo($resp);
            $object = $resp->getSendSmsResp();
            if($object){
                $res['result']['smsMsgId'] = $object->getSmsMsgId();
            }
            return $res;
        }else{
            return false;
        }
    }

    private function request($handle, $message, &$response)
    {
        $res = false;
        try{
            $res = $handle->request($message, $response);
        } catch (\Ice_InvocationTimeoutException $ex) {
            echo "[".date("Y-m-d H:i:s")."] request error :".print_r ($message,true);
            echo "\n";
        }
        return $res;
    }

    /**
     * 设置基础返回
     * @param ResponseInfo $resp
     * @return array
     */
    private function baseInfo(ResponseInfo $resp):array
    {
        $baseInfo = $resp->getBaseInfo();
        $base['error']     = $baseInfo->getError();
        $base['reason']    = $baseInfo->getReason();
        $base['messageId'] = $baseInfo->getMessageId();
        $base['timestamp'] = $baseInfo->getTimestamp();
        $base['result']    = [];
        return $base;
    }
}