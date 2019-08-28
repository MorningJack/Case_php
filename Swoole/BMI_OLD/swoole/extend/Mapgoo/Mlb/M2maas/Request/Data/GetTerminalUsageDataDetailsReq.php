<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetTerminalUsageDataDetailsReq message
 */
class GetTerminalUsageDataDetailsReq extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const CYCLESTARTDATE = 2;
    const PAGENUMBER = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CYCLESTARTDATE => array(
            'name' => 'cycleStartDate',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PAGENUMBER => array(
            'name' => 'pageNumber',
            'required' => false,
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
        $this->values[self::ICCID] = null;
        $this->values[self::CYCLESTARTDATE] = null;
        $this->values[self::PAGENUMBER] = null;
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
     * Sets value of 'cycleStartDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCycleStartDate($value)
    {
        return $this->set(self::CYCLESTARTDATE, $value);
    }

    /**
     * Returns value of 'cycleStartDate' property
     *
     * @return string
     */
    public function getCycleStartDate()
    {
        $value = $this->get(self::CYCLESTARTDATE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'pageNumber' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPageNumber($value)
    {
        return $this->set(self::PAGENUMBER, $value);
    }

    /**
     * Returns value of 'pageNumber' property
     *
     * @return integer
     */
    public function getPageNumber()
    {
        $value = $this->get(self::PAGENUMBER);
        return $value === null ? (integer)$value : $value;
    }
}
}