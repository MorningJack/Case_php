<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * EditTerminalRatingReq message
 */
class EditTerminalRatingReq extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const TERMSTARTDATE = 2;
    const TERMENDDATE = 3;
    const RENEWALMODE = 4;
    const RENEWALRATEPLAN = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMSTARTDATE => array(
            'name' => 'termStartDate',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMENDDATE => array(
            'name' => 'termEndDate',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RENEWALMODE => array(
            'name' => 'renewalMode',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RENEWALRATEPLAN => array(
            'name' => 'renewalRatePlan',
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
        $this->values[self::TERMSTARTDATE] = null;
        $this->values[self::TERMENDDATE] = null;
        $this->values[self::RENEWALMODE] = null;
        $this->values[self::RENEWALRATEPLAN] = null;
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
     * Sets value of 'termStartDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTermStartDate($value)
    {
        return $this->set(self::TERMSTARTDATE, $value);
    }

    /**
     * Returns value of 'termStartDate' property
     *
     * @return string
     */
    public function getTermStartDate()
    {
        $value = $this->get(self::TERMSTARTDATE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'termEndDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTermEndDate($value)
    {
        return $this->set(self::TERMENDDATE, $value);
    }

    /**
     * Returns value of 'termEndDate' property
     *
     * @return string
     */
    public function getTermEndDate()
    {
        $value = $this->get(self::TERMENDDATE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'renewalMode' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRenewalMode($value)
    {
        return $this->set(self::RENEWALMODE, $value);
    }

    /**
     * Returns value of 'renewalMode' property
     *
     * @return string
     */
    public function getRenewalMode()
    {
        $value = $this->get(self::RENEWALMODE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'renewalRatePlan' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRenewalRatePlan($value)
    {
        return $this->set(self::RENEWALRATEPLAN, $value);
    }

    /**
     * Returns value of 'renewalRatePlan' property
     *
     * @return string
     */
    public function getRenewalRatePlan()
    {
        $value = $this->get(self::RENEWALRATEPLAN);
        return $value === null ? (string)$value : $value;
    }
}
}