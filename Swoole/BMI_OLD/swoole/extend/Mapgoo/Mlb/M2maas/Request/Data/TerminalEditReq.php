<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * TerminalEditReq message
 */
class TerminalEditReq extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const CHANGETYPE = 2;
    const TARGETVALUE = 3;
    const EFFECTIVEDATE = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CHANGETYPE => array(
            'name' => 'changeType',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TARGETVALUE => array(
            'name' => 'targetValue',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::EFFECTIVEDATE => array(
            'name' => 'effectiveDate',
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
        $this->values[self::CHANGETYPE] = null;
        $this->values[self::TARGETVALUE] = null;
        $this->values[self::EFFECTIVEDATE] = null;
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
     * Sets value of 'changeType' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChangeType($value)
    {
        return $this->set(self::CHANGETYPE, $value);
    }

    /**
     * Returns value of 'changeType' property
     *
     * @return integer
     */
    public function getChangeType()
    {
        $value = $this->get(self::CHANGETYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'targetValue' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTargetValue($value)
    {
        return $this->set(self::TARGETVALUE, $value);
    }

    /**
     * Returns value of 'targetValue' property
     *
     * @return string
     */
    public function getTargetValue()
    {
        $value = $this->get(self::TARGETVALUE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'effectiveDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setEffectiveDate($value)
    {
        return $this->set(self::EFFECTIVEDATE, $value);
    }

    /**
     * Returns value of 'effectiveDate' property
     *
     * @return string
     */
    public function getEffectiveDate()
    {
        $value = $this->get(self::EFFECTIVEDATE);
        return $value === null ? (string)$value : $value;
    }
}
}