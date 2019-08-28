<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/11 17:53
 * Email: 1183@mapgoo.net
 */

use mapgoo\base\Route;

Route::post([
    'api/terminal/edit'            =>  'api/Terminal/editTerminal',
    'api/terminal/get'             =>  'api/Terminal/getTerminalDetails',
    'api/terminal/getmodified'     =>  'api/Terminal/getModified',
    'api/terminal/getrating'       =>  'api/Terminal/getTerminalRating',
    'api/terminal/getaudittrail'   =>  'api/Terminal/getTerminalAuditTrail',

    'api/terminalUsage/getdetail'  =>  'api/TerminalUsage/getTerminalUsageDataDetails',
    'api/terminalUsage/get'        =>  'api/TerminalUsage/getTerminalUsage',

    'api/NetworkAccessConfig/get'  =>  'api/NetworkAccessConfig/getNetworkAccessConfig',
    'api/NetworkAccessConfig/edit' =>  'api/NetworkAccessConfig/editNetworkAccessConfig',

    'api/rateplan/queue'           =>  'api/Rateplan/queueTerminalRatePlan',
    'api/rateplan/edit'            =>  'api/Rateplan/editTerminalRating',

    'api/session/get'              =>  'api/Session/getSessionInfo',

    'api/sms/sendsms'              =>  'api/Sms/sendSms',
]);