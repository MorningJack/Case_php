<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * GetModifiedTerminalsReq message
 */
class GetModifiedTerminalsReq extends \ProtobufMessage
{
    /* Field index constants */
    const SINCE = 1;
    const SIMSTATE = 2;
    const ACCOUNTID = 3;
    const PAGENUMBER = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SINCE => array(
            'name' => 'since',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SIMSTATE => array(
            'name' => 'simState',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACCOUNTID => array(
            'name' => 'accountId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
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
        $this->values[self::SINCE] = null;
        $this->values[self::SIMSTATE] = null;
        $this->values[self::ACCOUNTID] = null;
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
     * Sets value of 'since' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSince($value)
    {
        return $this->set(self::SINCE, $value);
    }

    /**
     * Returns value of 'since' property
     *
     * @return string
     */
    public function getSince()
    {
        $value = $this->get(self::SINCE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'simState' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSimState($value)
    {
        return $this->set(self::SIMSTATE, $value);
    }

    /**
     * Returns value of 'simState' property
     *
     * @return integer
     */
    public function getSimState()
    {
        $value = $this->get(self::SIMSTATE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'accountId' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAccountId($value)
    {
        return $this->set(self::ACCOUNTID, $value);
    }

    /**
     * Returns value of 'accountId' property
     *
     * @return integer
     */
    public function getAccountId()
    {
        $value = $this->get(self::ACCOUNTID);
        return $value === null ? (integer)$value : $value;
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