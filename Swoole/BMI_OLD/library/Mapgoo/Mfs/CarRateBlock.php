<?php
/**
 * Auto generated from mfs.proto at 2018-03-14 10:38:25
 *
 * mapgoo.mfs package
 */

namespace Mapgoo\Mfs {
/**
 * CarRateBlock message
 */
class CarRateBlock extends \ProtobufMessage
{
    /* Field index constants */
    const SPEED = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SPEED => array(
            'name' => 'speed',
            'repeated' => true,
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
        $this->values[self::SPEED] = array();
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
     * Appends value to 'speed' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendSpeed($value)
    {
        return $this->append(self::SPEED, $value);
    }

    /**
     * Clears 'speed' list
     *
     * @return null
     */
    public function clearSpeed()
    {
        return $this->clear(self::SPEED);
    }

    /**
     * Returns 'speed' list
     *
     * @return integer[]
     */
    public function getSpeed()
    {
        return $this->get(self::SPEED);
    }

    /**
     * Returns 'speed' iterator
     *
     * @return \ArrayIterator
     */
    public function getSpeedIterator()
    {
        return new \ArrayIterator($this->get(self::SPEED));
    }

    /**
     * Returns element from 'speed' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getSpeedAt($offset)
    {
        return $this->get(self::SPEED, $offset);
    }

    /**
     * Returns count of 'speed' list
     *
     * @return int
     */
    public function getSpeedCount()
    {
        return $this->count(self::SPEED);
    }
}
}