<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetTerminalDetailResp message
 */
class GetTerminalDetailResp extends \ProtobufMessage
{
    /* Field index constants */
    const INFOS = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::INFOS => array(
            'name' => 'infos',
            'repeated' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\TerminalDetailInfo'
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
        $this->values[self::INFOS] = array();
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
     * Appends value to 'infos' list
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\TerminalDetailInfo $value Value to append
     *
     * @return null
     */
    public function appendInfos(\Mapgoo\Mlb\M2maas\Request\Data\TerminalDetailInfo $value)
    {
        return $this->append(self::INFOS, $value);
    }

    /**
     * Clears 'infos' list
     *
     * @return null
     */
    public function clearInfos()
    {
        return $this->clear(self::INFOS);
    }

    /**
     * Returns 'infos' list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalDetailInfo[]
     */
    public function getInfos()
    {
        return $this->get(self::INFOS);
    }

    /**
     * Returns 'infos' iterator
     *
     * @return \ArrayIterator
     */
    public function getInfosIterator()
    {
        return new \ArrayIterator($this->get(self::INFOS));
    }

    /**
     * Returns element from 'infos' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalDetailInfo
     */
    public function getInfosAt($offset)
    {
        return $this->get(self::INFOS, $offset);
    }

    /**
     * Returns count of 'infos' list
     *
     * @return int
     */
    public function getInfosCount()
    {
        return $this->count(self::INFOS);
    }
}
}