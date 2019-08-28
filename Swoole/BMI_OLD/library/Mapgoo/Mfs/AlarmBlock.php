<?php
/**
 * Auto generated from mfs.proto at 2018-03-14 10:38:25
 *
 * mapgoo.mfs package
 */

namespace Mapgoo\Mfs {
/**
 * AlarmBlock message
 */
class AlarmBlock extends \ProtobufMessage
{
    /* Field index constants */
    const MDTALARM = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::MDTALARM => array(
            'name' => 'mdtAlarm',
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
        $this->values[self::MDTALARM] = null;
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
     * Sets value of 'mdtAlarm' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMdtAlarm($value)
    {
        return $this->set(self::MDTALARM, $value);
    }

    /**
     * Returns value of 'mdtAlarm' property
     *
     * @return string
     */
    public function getMdtAlarm()
    {
        $value = $this->get(self::MDTALARM);
        return $value === null ? (string)$value : $value;
    }
}
}