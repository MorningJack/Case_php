<?php
/**
 * Auto generated from mfs.proto at 2018-03-14 10:38:25
 *
 * mapgoo.mfs package
 */

namespace Mapgoo\Mfs {
/**
 * StatusBlock message
 */
class StatusBlock extends \ProtobufMessage
{
    /* Field index constants */
    const BATTERY = 1;
    const GSMSTRENGTH = 2;
    const MDTSTATUS = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::BATTERY => array(
            'name' => 'battery',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GSMSTRENGTH => array(
            'name' => 'gsmStrength',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MDTSTATUS => array(
            'name' => 'mdtStatus',
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
        $this->values[self::BATTERY] = null;
        $this->values[self::GSMSTRENGTH] = null;
        $this->values[self::MDTSTATUS] = null;
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
     * Sets value of 'battery' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBattery($value)
    {
        return $this->set(self::BATTERY, $value);
    }

    /**
     * Returns value of 'battery' property
     *
     * @return integer
     */
    public function getBattery()
    {
        $value = $this->get(self::BATTERY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'gsmStrength' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGsmStrength($value)
    {
        return $this->set(self::GSMSTRENGTH, $value);
    }

    /**
     * Returns value of 'gsmStrength' property
     *
     * @return integer
     */
    public function getGsmStrength()
    {
        $value = $this->get(self::GSMSTRENGTH);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'mdtStatus' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMdtStatus($value)
    {
        return $this->set(self::MDTSTATUS, $value);
    }

    /**
     * Returns value of 'mdtStatus' property
     *
     * @return string
     */
    public function getMdtStatus()
    {
        $value = $this->get(self::MDTSTATUS);
        return $value === null ? (string)$value : $value;
    }
}
}