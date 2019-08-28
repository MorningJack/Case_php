<?php
/**
 * Auto generated from mfs.proto at 2018-03-14 10:38:25
 *
 * mapgoo.mfs package
 */

namespace Mapgoo\Mfs {
/**
 * MessageType enum
 */
final class MessageType
{
    const MSG_TYPE_LOGIN = 1;
    const MSG_TYPE_LOCATION = 2;
    const MSG_TYPE_HEARTBEAT = 4;
    const MSG_TYPE_OBD_PID = 8;
    const MSG_TYPE_OBD_TRAVEL_START_EVENT = 16;
    const MSG_TYPE_OBD_TRAVEL_STOP_EVENT = 32;
    const MSG_TYPE_ODB_TRAVEL = 64;
    const MSG_TYPE_ALARM = 128;
    const MSG_TYPE_STATUS = 256;
    const MSG_TYPE_REPLY = 512;
    const MSG_TYPE_ARGS = 1024;
    const MSG_TYPE_REQ_INFO = 2048;
    const MSG_TYPE_CAR_RATE = 4096;
    const MSG_TYPE_OTHER = 8192;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'MSG_TYPE_LOGIN' => self::MSG_TYPE_LOGIN,
            'MSG_TYPE_LOCATION' => self::MSG_TYPE_LOCATION,
            'MSG_TYPE_HEARTBEAT' => self::MSG_TYPE_HEARTBEAT,
            'MSG_TYPE_OBD_PID' => self::MSG_TYPE_OBD_PID,
            'MSG_TYPE_OBD_TRAVEL_START_EVENT' => self::MSG_TYPE_OBD_TRAVEL_START_EVENT,
            'MSG_TYPE_OBD_TRAVEL_STOP_EVENT' => self::MSG_TYPE_OBD_TRAVEL_STOP_EVENT,
            'MSG_TYPE_ODB_TRAVEL' => self::MSG_TYPE_ODB_TRAVEL,
            'MSG_TYPE_ALARM' => self::MSG_TYPE_ALARM,
            'MSG_TYPE_STATUS' => self::MSG_TYPE_STATUS,
            'MSG_TYPE_REPLY' => self::MSG_TYPE_REPLY,
            'MSG_TYPE_ARGS' => self::MSG_TYPE_ARGS,
            'MSG_TYPE_REQ_INFO' => self::MSG_TYPE_REQ_INFO,
            'MSG_TYPE_CAR_RATE' => self::MSG_TYPE_CAR_RATE,
            'MSG_TYPE_OTHER' => self::MSG_TYPE_OTHER,
        );
    }
}
}