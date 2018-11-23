<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * SessionInfo message
 */
class SessionInfo extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const IPADDRESS = 2;
    const IPV6ADDRESS = 3;
    const DATESESSIONSTARTED = 4;
    const DATESESSIONENDED = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::IPADDRESS => array(
            'name' => 'ipAddress',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::IPV6ADDRESS => array(
            'name' => 'ipv6Address',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DATESESSIONSTARTED => array(
            'name' => 'dateSessionStarted',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DATESESSIONENDED => array(
            'name' => 'dateSessionEnded',
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
        $this->values[self::IPADDRESS] = null;
        $this->values[self::IPV6ADDRESS] = null;
        $this->values[self::DATESESSIONSTARTED] = null;
        $this->values[self::DATESESSIONENDED] = null;
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
     * Sets value of 'ipAddress' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIpAddress($value)
    {
        return $this->set(self::IPADDRESS, $value);
    }

    /**
     * Returns value of 'ipAddress' property
     *
     * @return string
     */
    public function getIpAddress()
    {
        $value = $this->get(self::IPADDRESS);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'ipv6Address' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIpv6Address($value)
    {
        return $this->set(self::IPV6ADDRESS, $value);
    }

    /**
     * Returns value of 'ipv6Address' property
     *
     * @return string
     */
    public function getIpv6Address()
    {
        $value = $this->get(self::IPV6ADDRESS);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'dateSessionStarted' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDateSessionStarted($value)
    {
        return $this->set(self::DATESESSIONSTARTED, $value);
    }

    /**
     * Returns value of 'dateSessionStarted' property
     *
     * @return string
     */
    public function getDateSessionStarted()
    {
        $value = $this->get(self::DATESESSIONSTARTED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'dateSessionEnded' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDateSessionEnded($value)
    {
        return $this->set(self::DATESESSIONENDED, $value);
    }

    /**
     * Returns value of 'dateSessionEnded' property
     *
     * @return string
     */
    public function getDateSessionEnded()
    {
        $value = $this->get(self::DATESESSIONENDED);
        return $value === null ? (string)$value : $value;
    }
}
}