<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetModifiedTerminalsResp message
 */
class GetModifiedTerminalsResp extends \ProtobufMessage
{
    /* Field index constants */
    const TOTALPAGES = 1;
    const ICCIDS = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TOTALPAGES => array(
            'name' => 'totalPages',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ICCIDS => array(
            'name' => 'iccids',
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
        $this->values[self::TOTALPAGES] = null;
        $this->values[self::ICCIDS] = array();
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
     * Sets value of 'totalPages' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalPages($value)
    {
        return $this->set(self::TOTALPAGES, $value);
    }

    /**
     * Returns value of 'totalPages' property
     *
     * @return integer
     */
    public function getTotalPages()
    {
        $value = $this->get(self::TOTALPAGES);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Appends value to 'iccids' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendIccids($value)
    {
        return $this->append(self::ICCIDS, $value);
    }

    /**
     * Clears 'iccids' list
     *
     * @return null
     */
    public function clearIccids()
    {
        return $this->clear(self::ICCIDS);
    }

    /**
     * Returns 'iccids' list
     *
     * @return string[]
     */
    public function getIccids()
    {
        return $this->get(self::ICCIDS);
    }

    /**
     * Returns 'iccids' iterator
     *
     * @return \ArrayIterator
     */
    public function getIccidsIterator()
    {
        return new \ArrayIterator($this->get(self::ICCIDS));
    }

    /**
     * Returns element from 'iccids' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getIccidsAt($offset)
    {
        return $this->get(self::ICCIDS, $offset);
    }

    /**
     * Returns count of 'iccids' list
     *
     * @return int
     */
    public function getIccidsCount()
    {
        return $this->count(self::ICCIDS);
    }
}
}