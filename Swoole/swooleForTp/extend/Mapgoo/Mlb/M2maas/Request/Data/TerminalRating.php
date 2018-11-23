<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * TerminalRating message
 */
class TerminalRating extends \ProtobufMessage
{
    /* Field index constants */
    const RATEPLANNAME = 1;
    const QUEUEPOSITION = 2;
    const EXPIRATIONDATE = 3;
    const TERMLENGTH = 4;
    const DATAREMAINING = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RATEPLANNAME => array(
            'name' => 'ratePlanName',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::QUEUEPOSITION => array(
            'name' => 'queuePosition',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::EXPIRATIONDATE => array(
            'name' => 'expirationDate',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMLENGTH => array(
            'name' => 'termLength',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DATAREMAINING => array(
            'name' => 'dataRemaining',
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
        $this->values[self::RATEPLANNAME] = null;
        $this->values[self::QUEUEPOSITION] = null;
        $this->values[self::EXPIRATIONDATE] = null;
        $this->values[self::TERMLENGTH] = null;
        $this->values[self::DATAREMAINING] = null;
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
     * Sets value of 'ratePlanName' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRatePlanName($value)
    {
        return $this->set(self::RATEPLANNAME, $value);
    }

    /**
     * Returns value of 'ratePlanName' property
     *
     * @return string
     */
    public function getRatePlanName()
    {
        $value = $this->get(self::RATEPLANNAME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'queuePosition' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setQueuePosition($value)
    {
        return $this->set(self::QUEUEPOSITION, $value);
    }

    /**
     * Returns value of 'queuePosition' property
     *
     * @return integer
     */
    public function getQueuePosition()
    {
        $value = $this->get(self::QUEUEPOSITION);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'expirationDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setExpirationDate($value)
    {
        return $this->set(self::EXPIRATIONDATE, $value);
    }

    /**
     * Returns value of 'expirationDate' property
     *
     * @return string
     */
    public function getExpirationDate()
    {
        $value = $this->get(self::EXPIRATIONDATE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'termLength' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTermLength($value)
    {
        return $this->set(self::TERMLENGTH, $value);
    }

    /**
     * Returns value of 'termLength' property
     *
     * @return integer
     */
    public function getTermLength()
    {
        $value = $this->get(self::TERMLENGTH);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'dataRemaining' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDataRemaining($value)
    {
        return $this->set(self::DATAREMAINING, $value);
    }

    /**
     * Returns value of 'dataRemaining' property
     *
     * @return integer
     */
    public function getDataRemaining()
    {
        $value = $this->get(self::DATAREMAINING);
        return $value === null ? (integer)$value : $value;
    }
}
}