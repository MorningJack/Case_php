<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * EditTerminalRatingResp message
 */
class EditTerminalRatingResp extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const STATUS = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::STATUS => array(
            'name' => 'status',
            'required' => true,
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
        $this->values[self::STATUS] = null;
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
}
}