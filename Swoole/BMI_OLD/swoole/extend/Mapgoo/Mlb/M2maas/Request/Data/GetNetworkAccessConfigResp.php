<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetNetworkAccessConfigResp message
 */
class GetNetworkAccessConfigResp extends \ProtobufMessage
{
    /* Field index constants */
    const NACIDS = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NACIDS => array(
            'name' => 'nacIds',
            'repeated' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\NacIds'
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
        $this->values[self::NACIDS] = array();
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
     * Appends value to 'nacIds' list
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\NacIds $value Value to append
     *
     * @return null
     */
    public function appendNacIds(\Mapgoo\Mlb\M2maas\Request\Data\NacIds $value)
    {
        return $this->append(self::NACIDS, $value);
    }

    /**
     * Clears 'nacIds' list
     *
     * @return null
     */
    public function clearNacIds()
    {
        return $this->clear(self::NACIDS);
    }

    /**
     * Returns 'nacIds' list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\NacIds[]
     */
    public function getNacIds()
    {
        return $this->get(self::NACIDS);
    }

    /**
     * Returns 'nacIds' iterator
     *
     * @return \ArrayIterator
     */
    public function getNacIdsIterator()
    {
        return new \ArrayIterator($this->get(self::NACIDS));
    }

    /**
     * Returns element from 'nacIds' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\NacIds
     */
    public function getNacIdsAt($offset)
    {
        return $this->get(self::NACIDS, $offset);
    }

    /**
     * Returns count of 'nacIds' list
     *
     * @return int
     */
    public function getNacIdsCount()
    {
        return $this->count(self::NACIDS);
    }
}
}