<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetSessionInfoResp message
 */
class GetSessionInfoResp extends \ProtobufMessage
{
    /* Field index constants */
    const SESSIONINFOS = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SESSIONINFOS => array(
            'name' => 'sessionInfos',
            'repeated' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\SessionInfo'
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
        $this->values[self::SESSIONINFOS] = array();
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
     * Appends value to 'sessionInfos' list
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\SessionInfo $value Value to append
     *
     * @return null
     */
    public function appendSessionInfos(\Mapgoo\Mlb\M2maas\Request\Data\SessionInfo $value)
    {
        return $this->append(self::SESSIONINFOS, $value);
    }

    /**
     * Clears 'sessionInfos' list
     *
     * @return null
     */
    public function clearSessionInfos()
    {
        return $this->clear(self::SESSIONINFOS);
    }

    /**
     * Returns 'sessionInfos' list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\SessionInfo[]
     */
    public function getSessionInfos()
    {
        return $this->get(self::SESSIONINFOS);
    }

    /**
     * Returns 'sessionInfos' iterator
     *
     * @return \ArrayIterator
     */
    public function getSessionInfosIterator()
    {
        return new \ArrayIterator($this->get(self::SESSIONINFOS));
    }

    /**
     * Returns element from 'sessionInfos' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\SessionInfo
     */
    public function getSessionInfosAt($offset)
    {
        return $this->get(self::SESSIONINFOS, $offset);
    }

    /**
     * Returns count of 'sessionInfos' list
     *
     * @return int
     */
    public function getSessionInfosCount()
    {
        return $this->count(self::SESSIONINFOS);
    }
}
}