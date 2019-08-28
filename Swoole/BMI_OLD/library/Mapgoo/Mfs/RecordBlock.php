<?php
/**
 * Auto generated from mfs.proto at 2018-03-14 10:38:25
 *
 * mapgoo.mfs package
 */

namespace Mapgoo\Mfs {
/**
 * RecordBlock message
 */
class RecordBlock extends \ProtobufMessage
{
    /* Field index constants */
    const OBJECTID = 1;
    const RCVTIME = 2;
    const MESSAGETYPE = 3;
    const TRACK = 4;
    const STATUS = 5;
    const ALARM = 6;
    const CARRATE = 7;
    const STATUSDESC = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::OBJECTID => array(
            'name' => 'objectId',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::RCVTIME => array(
            'name' => 'rcvTime',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MESSAGETYPE => array(
            'name' => 'messageType',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TRACK => array(
            'name' => 'track',
            'required' => false,
            'type' => '\Mapgoo\Mfs\TrackBlock'
        ),
        self::STATUS => array(
            'name' => 'status',
            'required' => false,
            'type' => '\Mapgoo\Mfs\StatusBlock'
        ),
        self::ALARM => array(
            'name' => 'alarm',
            'required' => false,
            'type' => '\Mapgoo\Mfs\AlarmBlock'
        ),
        self::CARRATE => array(
            'name' => 'carRate',
            'required' => false,
            'type' => '\Mapgoo\Mfs\CarRateBlock'
        ),
        self::STATUSDESC => array(
            'name' => 'statusDesc',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::OBJECTID] = null;
        $this->values[self::RCVTIME] = null;
        $this->values[self::MESSAGETYPE] = null;
        $this->values[self::TRACK] = null;
        $this->values[self::STATUS] = null;
        $this->values[self::ALARM] = null;
        $this->values[self::CARRATE] = null;
        $this->values[self::STATUSDESC] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'objectId' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setObjectId($value)
    {
        return $this->set(self::OBJECTID, $value);
    }

    /**
     * Returns value of 'objectId' property
     *
     * @return integer
     */
    public function getObjectId()
    {
        $value = $this->get(self::OBJECTID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'rcvTime' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRcvTime($value)
    {
        return $this->set(self::RCVTIME, $value);
    }

    /**
     * Returns value of 'rcvTime' property
     *
     * @return integer
     */
    public function getRcvTime()
    {
        $value = $this->get(self::RCVTIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'messageType' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMessageType($value)
    {
        return $this->set(self::MESSAGETYPE, $value);
    }

    /**
     * Returns value of 'messageType' property
     *
     * @return integer
     */
    public function getMessageType()
    {
        $value = $this->get(self::MESSAGETYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'track' property
     *
     * @param \Mapgoo\Mfs\TrackBlock $value Property value
     *
     * @return null
     */
    public function setTrack(\Mapgoo\Mfs\TrackBlock $value=null)
    {
        return $this->set(self::TRACK, $value);
    }

    /**
     * Returns value of 'track' property
     *
     * @return \Mapgoo\Mfs\TrackBlock
     */
    public function getTrack()
    {
        return $this->get(self::TRACK);
    }

    /**
     * Sets value of 'status' property
     *
     * @param \Mapgoo\Mfs\StatusBlock $value Property value
     *
     * @return null
     */
    public function setStatus(\Mapgoo\Mfs\StatusBlock $value=null)
    {
        return $this->set(self::STATUS, $value);
    }

    /**
     * Returns value of 'status' property
     *
     * @return \Mapgoo\Mfs\StatusBlock
     */
    public function getStatus()
    {
        return $this->get(self::STATUS);
    }

    /**
     * Sets value of 'alarm' property
     *
     * @param \Mapgoo\Mfs\AlarmBlock $value Property value
     *
     * @return null
     */
    public function setAlarm(\Mapgoo\Mfs\AlarmBlock $value=null)
    {
        return $this->set(self::ALARM, $value);
    }

    /**
     * Returns value of 'alarm' property
     *
     * @return \Mapgoo\Mfs\AlarmBlock
     */
    public function getAlarm()
    {
        return $this->get(self::ALARM);
    }

    /**
     * Sets value of 'carRate' property
     *
     * @param \Mapgoo\Mfs\CarRateBlock $value Property value
     *
     * @return null
     */
    public function setCarRate(\Mapgoo\Mfs\CarRateBlock $value=null)
    {
        return $this->set(self::CARRATE, $value);
    }

    /**
     * Returns value of 'carRate' property
     *
     * @return \Mapgoo\Mfs\CarRateBlock
     */
    public function getCarRate()
    {
        return $this->get(self::CARRATE);
    }

    /**
     * Sets value of 'statusDesc' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setStatusDesc($value)
    {
        return $this->set(self::STATUSDESC, $value);
    }

    /**
     * Returns value of 'statusDesc' property
     *
     * @return string
     */
    public function getStatusDesc()
    {
        $value = $this->get(self::STATUSDESC);
        return $value === null ? (string)$value : $value;
    }
}
}