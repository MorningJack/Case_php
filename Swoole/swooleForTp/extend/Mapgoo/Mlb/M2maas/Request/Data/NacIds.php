<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * NacIds message
 */
class NacIds extends \ProtobufMessage
{
    /* Field index constants */
    const NACID = 1;
    const ICCID = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NACID => array(
            'name' => 'nacId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ICCID => array(
            'name' => 'iccid',
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
        $this->values[self::NACID] = null;
        $this->values[self::ICCID] = null;
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
     * Sets value of 'nacId' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNacId($value)
    {
        return $this->set(self::NACID, $value);
    }

    /**
     * Returns value of 'nacId' property
     *
     * @return integer
     */
    public function getNacId()
    {
        $value = $this->get(self::NACID);
        return $value === null ? (integer)$value : $value;
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
}
}