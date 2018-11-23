<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetTerminalUsageResp message
 */
class GetTerminalUsageResp extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const TERMINALID = 2;
    const CUSTOMER = 3;
    const ENDCONSUMERID = 4;
    const TOTALDATAVOLUME = 5;
    const BILLABLEDATAVOLUME = 6;
    const CYCLESTARTDATE = 7;
    const BILLABLE = 8;
    const TOTALSMSVOLUME = 9;
    const TOTALVOICEVOLUME = 10;
    const BILLABLESMSVOLUME = 11;
    const BILLABLEVOICEVOLUME = 12;
    const RATEPLAN = 13;
    const EVENTSUSAGE = 14;
    const TOTALEVENTS = 15;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMINALID => array(
            'name' => 'terminalId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOMER => array(
            'name' => 'customer',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ENDCONSUMERID => array(
            'name' => 'endConsumerId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TOTALDATAVOLUME => array(
            'name' => 'totalDataVolume',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BILLABLEDATAVOLUME => array(
            'name' => 'billableDataVolume',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CYCLESTARTDATE => array(
            'name' => 'cycleStartDate',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::BILLABLE => array(
            'name' => 'billable',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::TOTALSMSVOLUME => array(
            'name' => 'totalSMSVolume',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTALVOICEVOLUME => array(
            'name' => 'totalVoiceVolume',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BILLABLESMSVOLUME => array(
            'name' => 'billableSMSVolume',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BILLABLEVOICEVOLUME => array(
            'name' => 'billableVoiceVolume',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::RATEPLAN => array(
            'name' => 'ratePlan',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::EVENTSUSAGE => array(
            'name' => 'eventsUsage',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTALEVENTS => array(
            'name' => 'totalEvents',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
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
        $this->values[self::TERMINALID] = null;
        $this->values[self::CUSTOMER] = null;
        $this->values[self::ENDCONSUMERID] = null;
        $this->values[self::TOTALDATAVOLUME] = null;
        $this->values[self::BILLABLEDATAVOLUME] = null;
        $this->values[self::CYCLESTARTDATE] = null;
        $this->values[self::BILLABLE] = null;
        $this->values[self::TOTALSMSVOLUME] = null;
        $this->values[self::TOTALVOICEVOLUME] = null;
        $this->values[self::BILLABLESMSVOLUME] = null;
        $this->values[self::BILLABLEVOICEVOLUME] = null;
        $this->values[self::RATEPLAN] = null;
        $this->values[self::EVENTSUSAGE] = null;
        $this->values[self::TOTALEVENTS] = null;
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
     * Sets value of 'totalDataVolume' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalDataVolume($value)
    {
        return $this->set(self::TOTALDATAVOLUME, $value);
    }

    /**
     * Returns value of 'totalDataVolume' property
     *
     * @return integer
     */
    public function getTotalDataVolume()
    {
        $value = $this->get(self::TOTALDATAVOLUME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'billableDataVolume' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBillableDataVolume($value)
    {
        return $this->set(self::BILLABLEDATAVOLUME, $value);
    }

    /**
     * Returns value of 'billableDataVolume' property
     *
     * @return integer
     */
    public function getBillableDataVolume()
    {
        $value = $this->get(self::BILLABLEDATAVOLUME);
        return $value === null ? (integer)$value : $value;
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
     * Sets value of 'totalSMSVolume' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalSMSVolume($value)
    {
        return $this->set(self::TOTALSMSVOLUME, $value);
    }

    /**
     * Returns value of 'totalSMSVolume' property
     *
     * @return integer
     */
    public function getTotalSMSVolume()
    {
        $value = $this->get(self::TOTALSMSVOLUME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'totalVoiceVolume' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalVoiceVolume($value)
    {
        return $this->set(self::TOTALVOICEVOLUME, $value);
    }

    /**
     * Returns value of 'totalVoiceVolume' property
     *
     * @return integer
     */
    public function getTotalVoiceVolume()
    {
        $value = $this->get(self::TOTALVOICEVOLUME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'billableSMSVolume' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBillableSMSVolume($value)
    {
        return $this->set(self::BILLABLESMSVOLUME, $value);
    }

    /**
     * Returns value of 'billableSMSVolume' property
     *
     * @return integer
     */
    public function getBillableSMSVolume()
    {
        $value = $this->get(self::BILLABLESMSVOLUME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'billableVoiceVolume' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBillableVoiceVolume($value)
    {
        return $this->set(self::BILLABLEVOICEVOLUME, $value);
    }

    /**
     * Returns value of 'billableVoiceVolume' property
     *
     * @return integer
     */
    public function getBillableVoiceVolume()
    {
        $value = $this->get(self::BILLABLEVOICEVOLUME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'ratePlan' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRatePlan($value)
    {
        return $this->set(self::RATEPLAN, $value);
    }

    /**
     * Returns value of 'ratePlan' property
     *
     * @return string
     */
    public function getRatePlan()
    {
        $value = $this->get(self::RATEPLAN);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'eventsUsage' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setEventsUsage($value)
    {
        return $this->set(self::EVENTSUSAGE, $value);
    }

    /**
     * Returns value of 'eventsUsage' property
     *
     * @return integer
     */
    public function getEventsUsage()
    {
        $value = $this->get(self::EVENTSUSAGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'totalEvents' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalEvents($value)
    {
        return $this->set(self::TOTALEVENTS, $value);
    }

    /**
     * Returns value of 'totalEvents' property
     *
     * @return integer
     */
    public function getTotalEvents()
    {
        $value = $this->get(self::TOTALEVENTS);
        return $value === null ? (integer)$value : $value;
    }
}
}