<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetTerminalRatingResp message
 */
class GetTerminalRatingResp extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const TERMINALRATING = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMINALRATING => array(
            'name' => 'terminalRating',
            'repeated' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\TerminalRating'
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
        $this->values[self::TERMINALRATING] = array();
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
     * Appends value to 'terminalRating' list
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\TerminalRating $value Value to append
     *
     * @return null
     */
    public function appendTerminalRating(\Mapgoo\Mlb\M2maas\Request\Data\TerminalRating $value)
    {
        return $this->append(self::TERMINALRATING, $value);
    }

    /**
     * Clears 'terminalRating' list
     *
     * @return null
     */
    public function clearTerminalRating()
    {
        return $this->clear(self::TERMINALRATING);
    }

    /**
     * Returns 'terminalRating' list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalRating[]
     */
    public function getTerminalRating()
    {
        return $this->get(self::TERMINALRATING);
    }

    /**
     * Returns 'terminalRating' iterator
     *
     * @return \ArrayIterator
     */
    public function getTerminalRatingIterator()
    {
        return new \ArrayIterator($this->get(self::TERMINALRATING));
    }

    /**
     * Returns element from 'terminalRating' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalRating
     */
    public function getTerminalRatingAt($offset)
    {
        return $this->get(self::TERMINALRATING, $offset);
    }

    /**
     * Returns count of 'terminalRating' list
     *
     * @return int
     */
    public function getTerminalRatingCount()
    {
        return $this->count(self::TERMINALRATING);
    }
}
}