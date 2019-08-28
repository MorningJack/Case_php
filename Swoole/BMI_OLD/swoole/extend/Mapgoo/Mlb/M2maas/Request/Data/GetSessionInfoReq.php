<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetSessionInfoReq message
 */
class GetSessionInfoReq extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'repeated' => true,
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
        $this->values[self::ICCID] = array();
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
     * Appends value to 'iccid' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendIccid($value)
    {
        return $this->append(self::ICCID, $value);
    }

    /**
     * Clears 'iccid' list
     *
     * @return null
     */
    public function clearIccid()
    {
        return $this->clear(self::ICCID);
    }

    /**
     * Returns 'iccid' list
     *
     * @return string[]
     */
    public function getIccid()
    {
        return $this->get(self::ICCID);
    }

    /**
     * Returns 'iccid' iterator
     *
     * @return \ArrayIterator
     */
    public function getIccidIterator()
    {
        return new \ArrayIterator($this->get(self::ICCID));
    }

    /**
     * Returns element from 'iccid' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getIccidAt($offset)
    {
        return $this->get(self::ICCID, $offset);
    }

    /**
     * Returns count of 'iccid' list
     *
     * @return int
     */
    public function getIccidCount()
    {
        return $this->count(self::ICCID);
    }
}
}