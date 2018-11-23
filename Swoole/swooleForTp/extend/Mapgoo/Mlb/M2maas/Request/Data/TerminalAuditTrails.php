<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * TerminalAuditTrails message
 */
class TerminalAuditTrails extends \ProtobufMessage
{
    /* Field index constants */
    const FIELD = 1;
    const PRIORVALUE = 2;
    const VALUE = 3;
    const EFFECTIVEDATE = 4;
    const STATUS = 5;
    const USERNAME = 6;
    const DELEGATEDUSER = 7;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::FIELD => array(
            'name' => 'field',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PRIORVALUE => array(
            'name' => 'priorValue',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::VALUE => array(
            'name' => 'value',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::EFFECTIVEDATE => array(
            'name' => 'effectiveDate',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::STATUS => array(
            'name' => 'status',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::USERNAME => array(
            'name' => 'userName',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DELEGATEDUSER => array(
            'name' => 'delegatedUser',
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
        $this->values[self::FIELD] = null;
        $this->values[self::PRIORVALUE] = null;
        $this->values[self::VALUE] = null;
        $this->values[self::EFFECTIVEDATE] = null;
        $this->values[self::STATUS] = null;
        $this->values[self::USERNAME] = null;
        $this->values[self::DELEGATEDUSER] = null;
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
     * Sets value of 'field' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setField($value)
    {
        return $this->set(self::FIELD, $value);
    }

    /**
     * Returns value of 'field' property
     *
     * @return string
     */
    public function getField()
    {
        $value = $this->get(self::FIELD);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'priorValue' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPriorValue($value)
    {
        return $this->set(self::PRIORVALUE, $value);
    }

    /**
     * Returns value of 'priorValue' property
     *
     * @return string
     */
    public function getPriorValue()
    {
        $value = $this->get(self::PRIORVALUE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'value' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setValue($value)
    {
        return $this->set(self::VALUE, $value);
    }

    /**
     * Returns value of 'value' property
     *
     * @return string
     */
    public function getValue()
    {
        $value = $this->get(self::VALUE);
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

    /**
     * Sets value of 'status' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setStatus($value)
    {
        return $this->set(self::STATUS, $value);
    }

    /**
     * Returns value of 'status' property
     *
     * @return string
     */
    public function getStatus()
    {
        $value = $this->get(self::STATUS);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'userName' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setUserName($value)
    {
        return $this->set(self::USERNAME, $value);
    }

    /**
     * Returns value of 'userName' property
     *
     * @return string
     */
    public function getUserName()
    {
        $value = $this->get(self::USERNAME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'delegatedUser' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDelegatedUser($value)
    {
        return $this->set(self::DELEGATEDUSER, $value);
    }

    /**
     * Returns value of 'delegatedUser' property
     *
     * @return string
     */
    public function getDelegatedUser()
    {
        $value = $this->get(self::DELEGATEDUSER);
        return $value === null ? (string)$value : $value;
    }
}
}