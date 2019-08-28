<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * UsageDetails message
 */
class UsageDetails extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const CYCLESTARTDATE = 2;
    const TERMINALID = 3;
    const ENDCONSUMERID = 4;
    const CUSTOMER = 5;
    const BILLABLE = 6;
    const ZONE = 7;
    const SESSIONSTARTTIME = 8;
    const DURATION = 9;
    const DATAVOLUME = 10;
    const COUNTRYCODE = 11;
    const SERVICETYPE = 12;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CYCLESTARTDATE => array(
            'name' => 'cycleStartDate',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMINALID => array(
            'name' => 'terminalId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ENDCONSUMERID => array(
            'name' => 'endConsumerId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOMER => array(
            'name' => 'customer',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::BILLABLE => array(
            'name' => 'billable',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::ZONE => array(
            'name' => 'zone',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SESSIONSTARTTIME => array(
            'name' => 'sessionStartTime',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DURATION => array(
            'name' => 'duration',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DATAVOLUME => array(
            'name' => 'dataVolume',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COUNTRYCODE => array(
            'name' => 'countryCode',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SERVICETYPE => array(
            'name' => 'serviceType',
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
        $this->values[self::ICCID] = null;
        $this->values[self::CYCLESTARTDATE] = null;
        $this->values[self::TERMINALID] = null;
        $this->values[self::ENDCONSUMERID] = null;
        $this->values[self::CUSTOMER] = null;
        $this->values[self::BILLABLE] = null;
        $this->values[self::ZONE] = null;
        $this->values[self::SESSIONSTARTTIME] = null;
        $this->values[self::DURATION] = null;
        $this->values[self::DATAVOLUME] = null;
        $this->values[self::COUNTRYCODE] = null;
        $this->values[self::SERVICETYPE] = null;
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
     * Sets value of 'iccid' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIccid($value)
    {
        return $this->set(self::ICCID, $value);
    }

    /**
     * Returns value of 'iccid' property
     *
     * @return string
     */
    public function getIccid()
    {
        $value = $this->get(self::ICCID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'cycleStartDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCycleStartDate($value)
    {
        return $this->set(self::CYCLESTARTDATE, $value);
    }

    /**
     * Returns value of 'cycleStartDate' property
     *
     * @return string
     */
    public function getCycleStartDate()
    {
        $value = $this->get(self::CYCLESTARTDATE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'terminalId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTerminalId($value)
    {
        return $this->set(self::TERMINALID, $value);
    }

    /**
     * Returns value of 'terminalId' property
     *
     * @return string
     */
    public function getTerminalId()
    {
        $value = $this->get(self::TERMINALID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'endConsumerId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setEndConsumerId($value)
    {
        return $this->set(self::ENDCONSUMERID, $value);
    }

    /**
     * Returns value of 'endConsumerId' property
     *
     * @return string
     */
    public function getEndConsumerId()
    {
        $value = $this->get(self::ENDCONSUMERID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'customer' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustomer($value)
    {
        return $this->set(self::CUSTOMER, $value);
    }

    /**
     * Returns value of 'customer' property
     *
     * @return string
     */
    public function getCustomer()
    {
        $value = $this->get(self::CUSTOMER);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'billable' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setBillable($value)
    {
        return $this->set(self::BILLABLE, $value);
    }

    /**
     * Returns value of 'billable' property
     *
     * @return boolean
     */
    public function getBillable()
    {
        $value = $this->get(self::BILLABLE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Sets value of 'zone' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setZone($value)
    {
        return $this->set(self::ZONE, $value);
    }

    /**
     * Returns value of 'zone' property
     *
     * @return string
     */
    public function getZone()
    {
        $value = $this->get(self::ZONE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'sessionStartTime' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSessionStartTime($value)
    {
        return $this->set(self::SESSIONSTARTTIME, $value);
    }

    /**
     * Returns value of 'sessionStartTime' property
     *
     * @return string
     */
    public function getSessionStartTime()
    {
        $value = $this->get(self::SESSIONSTARTTIME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'duration' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDuration($value)
    {
        return $this->set(self::DURATION, $value);
    }

    /**
     * Returns value of 'duration' property
     *
     * @return integer
     */
    public function getDuration()
    {
        $value = $this->get(self::DURATION);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'dataVolume' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDataVolume($value)
    {
        return $this->set(self::DATAVOLUME, $value);
    }

    /**
     * Returns value of 'dataVolume' property
     *
     * @return integer
     */
    public function getDataVolume()
    {
        $value = $this->get(self::DATAVOLUME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'countryCode' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCountryCode($value)
    {
        return $this->set(self::COUNTRYCODE, $value);
    }

    /**
     * Returns value of 'countryCode' property
     *
     * @return string
     */
    public function getCountryCode()
    {
        $value = $this->get(self::COUNTRYCODE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'serviceType' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setServiceType($value)
    {
        return $this->set(self::SERVICETYPE, $value);
    }

    /**
     * Returns value of 'serviceType' property
     *
     * @return string
     */
    public function getServiceType()
    {
        $value = $this->get(self::SERVICETYPE);
        return $value === null ? (string)$value : $value;
    }
}
}