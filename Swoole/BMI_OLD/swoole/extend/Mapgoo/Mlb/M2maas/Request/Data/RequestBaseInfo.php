<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * RequestBaseInfo message
 */
class RequestBaseInfo extends \ProtobufMessage
{
    /* Field index constants */
    const MESSAGEID = 1;
    const SOURETYPE = 2;
    const SYNCTYPE = 3;
    const CALLBACKURL = 4;
    const PRIORITY = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::MESSAGEID => array(
            'name' => 'messageId',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SOURETYPE => array(
            'name' => 'soureType',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SYNCTYPE => array(
            'name' => 'syncType',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CALLBACKURL => array(
            'name' => 'callbackUrl',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PRIORITY => array(
            'name' => 'priority',
            'required' => true,
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
        $this->values[self::MESSAGEID] = null;
        $this->values[self::SOURETYPE] = null;
        $this->values[self::SYNCTYPE] = null;
        $this->values[self::CALLBACKURL] = null;
        $this->values[self::PRIORITY] = null;
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
     * Sets value of 'messageId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMessageId($value)
    {
        return $this->set(self::MESSAGEID, $value);
    }

    /**
     * Returns value of 'messageId' property
     *
     * @return string
     */
    public function getMessageId()
    {
        $value = $this->get(self::MESSAGEID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'soureType' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSoureType($value)
    {
        return $this->set(self::SOURETYPE, $value);
    }

    /**
     * Returns value of 'soureType' property
     *
     * @return integer
     */
    public function getSoureType()
    {
        $value = $this->get(self::SOURETYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'syncType' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSyncType($value)
    {
        return $this->set(self::SYNCTYPE, $value);
    }

    /**
     * Returns value of 'syncType' property
     *
     * @return integer
     */
    public function getSyncType()
    {
        $value = $this->get(self::SYNCTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'callbackUrl' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCallbackUrl($value)
    {
        return $this->set(self::CALLBACKURL, $value);
    }

    /**
     * Returns value of 'callbackUrl' property
     *
     * @return string
     */
    public function getCallbackUrl()
    {
        $value = $this->get(self::CALLBACKURL);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'priority' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPriority($value)
    {
        return $this->set(self::PRIORITY, $value);
    }

    /**
     * Returns value of 'priority' property
     *
     * @return integer
     */
    public function getPriority()
    {
        $value = $this->get(self::PRIORITY);
        return $value === null ? (integer)$value : $value;
    }
}
}