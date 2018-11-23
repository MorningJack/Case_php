<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetTerminalAuditTrailResp message
 */
class GetTerminalAuditTrailResp extends \ProtobufMessage
{
    /* Field index constants */
    const TOTALPAGES = 1;
    const TERMINALAUDITTRAILS = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TOTALPAGES => array(
            'name' => 'totalPages',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TERMINALAUDITTRAILS => array(
            'name' => 'terminalAuditTrails',
            'repeated' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\TerminalAuditTrails'
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
        $this->values[self::TERMINALAUDITTRAILS] = array();
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
     * Appends value to 'terminalAuditTrails' list
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\TerminalAuditTrails $value Value to append
     *
     * @return null
     */
    public function appendTerminalAuditTrails(\Mapgoo\Mlb\M2maas\Request\Data\TerminalAuditTrails $value)
    {
        return $this->append(self::TERMINALAUDITTRAILS, $value);
    }

    /**
     * Clears 'terminalAuditTrails' list
     *
     * @return null
     */
    public function clearTerminalAuditTrails()
    {
        return $this->clear(self::TERMINALAUDITTRAILS);
    }

    /**
     * Returns 'terminalAuditTrails' list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalAuditTrails[]
     */
    public function getTerminalAuditTrails()
    {
        return $this->get(self::TERMINALAUDITTRAILS);
    }

    /**
     * Returns 'terminalAuditTrails' iterator
     *
     * @return \ArrayIterator
     */
    public function getTerminalAuditTrailsIterator()
    {
        return new \ArrayIterator($this->get(self::TERMINALAUDITTRAILS));
    }

    /**
     * Returns element from 'terminalAuditTrails' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalAuditTrails
     */
    public function getTerminalAuditTrailsAt($offset)
    {
        return $this->get(self::TERMINALAUDITTRAILS, $offset);
    }

    /**
     * Returns count of 'terminalAuditTrails' list
     *
     * @return int
     */
    public function getTerminalAuditTrailsCount()
    {
        return $this->count(self::TERMINALAUDITTRAILS);
    }
}
}