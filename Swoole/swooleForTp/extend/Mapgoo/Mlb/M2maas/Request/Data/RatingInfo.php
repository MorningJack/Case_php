<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * RatingInfo message
 */
class RatingInfo extends \ProtobufMessage
{
    /* Field index constants */
    const TERMSTARTDATE = 1;
    const TERMENDDATE = 2;
    const RENEWALPOLICY = 3;
    const RENEWALRATEPLAN = 4;
    const TOTALPRIMARYINCLUDEDDATA = 5;
    const PRIMARYDATAREMAINING = 6;
    const TOTALPRIMARYINCLUDEDSMS = 7;
    const PRIMARYSMSREMAINING = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TERMSTARTDATE => array(
            'name' => 'termStartDate',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMENDDATE => array(
            'name' => 'termEndDate',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RENEWALPOLICY => array(
            'name' => 'renewalPolicy',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RENEWALRATEPLAN => array(
            'name' => 'renewalRatePlan',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TOTALPRIMARYINCLUDEDDATA => array(
            'name' => 'totalPrimaryIncludedData',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PRIMARYDATAREMAINING => array(
            'name' => 'primaryDataRemaining',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTALPRIMARYINCLUDEDSMS => array(
            'name' => 'totalPrimaryIncludedSMS',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PRIMARYSMSREMAINING => array(
            'name' => 'primarySMSRemaining',
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
        $this->values[self::TERMSTARTDATE] = null;
        $this->values[self::TERMENDDATE] = null;
        $this->values[self::RENEWALPOLICY] = null;
        $this->values[self::RENEWALRATEPLAN] = null;
        $this->values[self::TOTALPRIMARYINCLUDEDDATA] = null;
        $this->values[self::PRIMARYDATAREMAINING] = null;
        $this->values[self::TOTALPRIMARYINCLUDEDSMS] = null;
        $this->values[self::PRIMARYSMSREMAINING] = null;
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
     * Sets value of 'termStartDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTermStartDate($value)
    {
        return $this->set(self::TERMSTARTDATE, $value);
    }

    /**
     * Returns value of 'termStartDate' property
     *
     * @return string
     */
    public function getTermStartDate()
    {
        $value = $this->get(self::TERMSTARTDATE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'termEndDate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTermEndDate($value)
    {
        return $this->set(self::TERMENDDATE, $value);
    }

    /**
     * Returns value of 'termEndDate' property
     *
     * @return string
     */
    public function getTermEndDate()
    {
        $value = $this->get(self::TERMENDDATE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'renewalPolicy' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRenewalPolicy($value)
    {
        return $this->set(self::RENEWALPOLICY, $value);
    }

    /**
     * Returns value of 'renewalPolicy' property
     *
     * @return string
     */
    public function getRenewalPolicy()
    {
        $value = $this->get(self::RENEWALPOLICY);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'renewalRatePlan' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRenewalRatePlan($value)
    {
        return $this->set(self::RENEWALRATEPLAN, $value);
    }

    /**
     * Returns value of 'renewalRatePlan' property
     *
     * @return string
     */
    public function getRenewalRatePlan()
    {
        $value = $this->get(self::RENEWALRATEPLAN);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'totalPrimaryIncludedData' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalPrimaryIncludedData($value)
    {
        return $this->set(self::TOTALPRIMARYINCLUDEDDATA, $value);
    }

    /**
     * Returns value of 'totalPrimaryIncludedData' property
     *
     * @return integer
     */
    public function getTotalPrimaryIncludedData()
    {
        $value = $this->get(self::TOTALPRIMARYINCLUDEDDATA);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'primaryDataRemaining' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPrimaryDataRemaining($value)
    {
        return $this->set(self::PRIMARYDATAREMAINING, $value);
    }

    /**
     * Returns value of 'primaryDataRemaining' property
     *
     * @return integer
     */
    public function getPrimaryDataRemaining()
    {
        $value = $this->get(self::PRIMARYDATAREMAINING);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'totalPrimaryIncludedSMS' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalPrimaryIncludedSMS($value)
    {
        return $this->set(self::TOTALPRIMARYINCLUDEDSMS, $value);
    }

    /**
     * Returns value of 'totalPrimaryIncludedSMS' property
     *
     * @return integer
     */
    public function getTotalPrimaryIncludedSMS()
    {
        $value = $this->get(self::TOTALPRIMARYINCLUDEDSMS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'primarySMSRemaining' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPrimarySMSRemaining($value)
    {
        return $this->set(self::PRIMARYSMSREMAINING, $value);
    }

    /**
     * Returns value of 'primarySMSRemaining' property
     *
     * @return integer
     */
    public function getPrimarySMSRemaining()
    {
        $value = $this->get(self::PRIMARYSMSREMAINING);
        return $value === null ? (integer)$value : $value;
    }
}
}