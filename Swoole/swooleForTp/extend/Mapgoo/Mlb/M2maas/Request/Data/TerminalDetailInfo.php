<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * TerminalDetailInfo message
 */
class TerminalDetailInfo extends \ProtobufMessage
{
    /* Field index constants */
    const ICCID = 1;
    const TERMINALID = 2;
    const MODEMID = 3;
    const CUSTOMER = 4;
    const ENDCONSUMERID = 5;
    const SUSPENDED = 6;
    const RATEPLAN = 7;
    const STATUS = 8;
    const MONTHTODATEUSAGE = 9;
    const OVERAGELIMITREACHED = 10;
    const OVERAGELIMITOVERRIDE = 11;
    const DATEACTIVATED = 12;
    const DATEADDED = 13;
    const DATEMODIFIED = 14;
    const DATESHIPPED = 15;
    const MONTHTODATEDATAUSAGE = 16;
    const MONTHTODATESMSUSAGE = 17;
    const MONTHTODATEVOICEUSAGE = 18;
    const SECURESIMID = 19;
    const CUSTOM1 = 20;
    const CUSTOM2 = 21;
    const CUSTOM3 = 22;
    const CUSTOM4 = 23;
    const CUSTOM5 = 24;
    const CUSTOM6 = 25;
    const CUSTOM7 = 26;
    const CUSTOM8 = 27;
    const CUSTOM9 = 28;
    const CUSTOM10 = 29;
    const RATING = 30;
    const SECURESIMUSERNAMECOPYRULE = 31;
    const SECURESIMPASSWORDCOPYRULE = 32;
    const ACCOUNTID = 33;
    const FIXEDIPADDRESS = 34;
    const CTDSESSIONCOUNT = 35;
    const CUSTOMERCUSTOM1 = 36;
    const CUSTOMERCUSTOM2 = 37;
    const CUSTOMERCUSTOM3 = 38;
    const CUSTOMERCUSTOM4 = 39;
    const CUSTOMERCUSTOM5 = 40;
    const OPERATORCUSTOM1 = 41;
    const OPERATORCUSTOM2 = 42;
    const OPERATORCUSTOM3 = 43;
    const OPERATORCUSTOM4 = 44;
    const OPERATORCUSTOM5 = 45;
    const IMSI = 46;
    const PRIMARYICCID = 47;
    const IMEI = 48;
    const GLOBALSIMTYPE = 49;
    const SIMNOTES = 50;
    const VERSION = 51;
    const EUICCID = 52;
    const MSISDN = 53;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ICCID => array(
            'name' => 'iccid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TERMINALID => array(
            'name' => 'terminalId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::MODEMID => array(
            'name' => 'modemId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOMER => array(
            'name' => 'customer',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ENDCONSUMERID => array(
            'name' => 'endConsumerId',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SUSPENDED => array(
            'name' => 'suspended',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RATEPLAN => array(
            'name' => 'ratePlan',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::STATUS => array(
            'name' => 'status',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::MONTHTODATEUSAGE => array(
            'name' => 'monthToDateUsage',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OVERAGELIMITREACHED => array(
            'name' => 'overageLimitReached',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::OVERAGELIMITOVERRIDE => array(
            'name' => 'overageLimitOverride',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DATEACTIVATED => array(
            'name' => 'dateActivated',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DATEADDED => array(
            'name' => 'dateAdded',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DATEMODIFIED => array(
            'name' => 'dateModified',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DATESHIPPED => array(
            'name' => 'dateShipped',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::MONTHTODATEDATAUSAGE => array(
            'name' => 'monthToDateDataUsage',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MONTHTODATESMSUSAGE => array(
            'name' => 'monthToDateSMSUsage',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MONTHTODATEVOICEUSAGE => array(
            'name' => 'monthToDateVoiceUsage',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SECURESIMID => array(
            'name' => 'secureSimId',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM1 => array(
            'name' => 'custom1',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM2 => array(
            'name' => 'custom2',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM3 => array(
            'name' => 'custom3',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM4 => array(
            'name' => 'custom4',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM5 => array(
            'name' => 'custom5',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM6 => array(
            'name' => 'custom6',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM7 => array(
            'name' => 'custom7',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM8 => array(
            'name' => 'custom8',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM9 => array(
            'name' => 'custom9',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOM10 => array(
            'name' => 'custom10',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RATING => array(
            'name' => 'rating',
            'required' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\RatingInfo'
        ),
        self::SECURESIMUSERNAMECOPYRULE => array(
            'name' => 'secureSimUsernameCopyRule',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SECURESIMPASSWORDCOPYRULE => array(
            'name' => 'secureSimPasswordCopyRule',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ACCOUNTID => array(
            'name' => 'accountId',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FIXEDIPADDRESS => array(
            'name' => 'fixedIpAddress',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CTDSESSIONCOUNT => array(
            'name' => 'ctdSessionCount',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CUSTOMERCUSTOM1 => array(
            'name' => 'customerCustom1',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOMERCUSTOM2 => array(
            'name' => 'customerCustom2',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOMERCUSTOM3 => array(
            'name' => 'customerCustom3',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOMERCUSTOM4 => array(
            'name' => 'customerCustom4',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CUSTOMERCUSTOM5 => array(
            'name' => 'customerCustom5',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::OPERATORCUSTOM1 => array(
            'name' => 'operatorCustom1',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::OPERATORCUSTOM2 => array(
            'name' => 'operatorCustom2',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::OPERATORCUSTOM3 => array(
            'name' => 'operatorCustom3',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::OPERATORCUSTOM4 => array(
            'name' => 'operatorCustom4',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::OPERATORCUSTOM5 => array(
            'name' => 'operatorCustom5',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::IMSI => array(
            'name' => 'imsi',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PRIMARYICCID => array(
            'name' => 'primaryICCID',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::IMEI => array(
            'name' => 'imei',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::GLOBALSIMTYPE => array(
            'name' => 'globalSimType',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SIMNOTES => array(
            'name' => 'simNotes',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::VERSION => array(
            'name' => 'version',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::EUICCID => array(
            'name' => 'euiccid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::MSISDN => array(
            'name' => 'msisdn',
            'required' => false,
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
        $this->values[self::ICCID] = null;
        $this->values[self::TERMINALID] = null;
        $this->values[self::MODEMID] = null;
        $this->values[self::CUSTOMER] = null;
        $this->values[self::ENDCONSUMERID] = null;
        $this->values[self::SUSPENDED] = null;
        $this->values[self::RATEPLAN] = null;
        $this->values[self::STATUS] = null;
        $this->values[self::MONTHTODATEUSAGE] = null;
        $this->values[self::OVERAGELIMITREACHED] = null;
        $this->values[self::OVERAGELIMITOVERRIDE] = null;
        $this->values[self::DATEACTIVATED] = null;
        $this->values[self::DATEADDED] = null;
        $this->values[self::DATEMODIFIED] = null;
        $this->values[self::DATESHIPPED] = null;
        $this->values[self::MONTHTODATEDATAUSAGE] = null;
        $this->values[self::MONTHTODATESMSUSAGE] = null;
        $this->values[self::MONTHTODATEVOICEUSAGE] = null;
        $this->values[self::SECURESIMID] = null;
        $this->values[self::CUSTOM1] = null;
        $this->values[self::CUSTOM2] = null;
        $this->values[self::CUSTOM3] = null;
        $this->values[self::CUSTOM4] = null;
        $this->values[self::CUSTOM5] = null;
        $this->values[self::CUSTOM6] = null;
        $this->values[self::CUSTOM7] = null;
        $this->values[self::CUSTOM8] = null;
        $this->values[self::CUSTOM9] = null;
        $this->values[self::CUSTOM10] = null;
        $this->values[self::RATING] = null;
        $this->values[self::SECURESIMUSERNAMECOPYRULE] = null;
        $this->values[self::SECURESIMPASSWORDCOPYRULE] = null;
        $this->values[self::ACCOUNTID] = null;
        $this->values[self::FIXEDIPADDRESS] = null;
        $this->values[self::CTDSESSIONCOUNT] = null;
        $this->values[self::CUSTOMERCUSTOM1] = null;
        $this->values[self::CUSTOMERCUSTOM2] = null;
        $this->values[self::CUSTOMERCUSTOM3] = null;
        $this->values[self::CUSTOMERCUSTOM4] = null;
        $this->values[self::CUSTOMERCUSTOM5] = null;
        $this->values[self::OPERATORCUSTOM1] = null;
        $this->values[self::OPERATORCUSTOM2] = null;
        $this->values[self::OPERATORCUSTOM3] = null;
        $this->values[self::OPERATORCUSTOM4] = null;
        $this->values[self::OPERATORCUSTOM5] = null;
        $this->values[self::IMSI] = null;
        $this->values[self::PRIMARYICCID] = null;
        $this->values[self::IMEI] = null;
        $this->values[self::GLOBALSIMTYPE] = null;
        $this->values[self::SIMNOTES] = null;
        $this->values[self::VERSION] = null;
        $this->values[self::EUICCID] = null;
        $this->values[self::MSISDN] = null;
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
     * Sets value of 'terminalId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTerminalId($value)
    {
        return $this->set(self::TERMINALID, $value);
    }

    /**
     * Returns value of 'terminalId' property
     *
     * @return string
     */
    public function getTerminalId()
    {
        $value = $this->get(self::TERMINALID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'modemId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setModemId($value)
    {
        return $this->set(self::MODEMID, $value);
    }

    /**
     * Returns value of 'modemId' property
     *
     * @return string
     */
    public function getModemId()
    {
        $value = $this->get(self::MODEMID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'customer' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustomer($value)
    {
        return $this->set(self::CUSTOMER, $value);
    }

    /**
     * Returns value of 'customer' property
     *
     * @return string
     */
    public function getCustomer()
    {
        $value = $this->get(self::CUSTOMER);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'endConsumerId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setEndConsumerId($value)
    {
        return $this->set(self::ENDCONSUMERID, $value);
    }

    /**
     * Returns value of 'endConsumerId' property
     *
     * @return string
     */
    public function getEndConsumerId()
    {
        $value = $this->get(self::ENDCONSUMERID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'suspended' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSuspended($value)
    {
        return $this->set(self::SUSPENDED, $value);
    }

    /**
     * Returns value of 'suspended' property
     *
     * @return string
     */
    public function getSuspended()
    {
        $value = $this->get(self::SUSPENDED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'ratePlan' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRatePlan($value)
    {
        return $this->set(self::RATEPLAN, $value);
    }

    /**
     * Returns value of 'ratePlan' property
     *
     * @return string
     */
    public function getRatePlan()
    {
        $value = $this->get(self::RATEPLAN);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'status' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setStatus($value)
    {
        return $this->set(self::STATUS, $value);
    }

    /**
     * Returns value of 'status' property
     *
     * @return string
     */
    public function getStatus()
    {
        $value = $this->get(self::STATUS);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'monthToDateUsage' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMonthToDateUsage($value)
    {
        return $this->set(self::MONTHTODATEUSAGE, $value);
    }

    /**
     * Returns value of 'monthToDateUsage' property
     *
     * @return integer
     */
    public function getMonthToDateUsage()
    {
        $value = $this->get(self::MONTHTODATEUSAGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'overageLimitReached' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setOverageLimitReached($value)
    {
        return $this->set(self::OVERAGELIMITREACHED, $value);
    }

    /**
     * Returns value of 'overageLimitReached' property
     *
     * @return boolean
     */
    public function getOverageLimitReached()
    {
        $value = $this->get(self::OVERAGELIMITREACHED);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Sets value of 'overageLimitOverride' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOverageLimitOverride($value)
    {
        return $this->set(self::OVERAGELIMITOVERRIDE, $value);
    }

    /**
     * Returns value of 'overageLimitOverride' property
     *
     * @return string
     */
    public function getOverageLimitOverride()
    {
        $value = $this->get(self::OVERAGELIMITOVERRIDE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'dateActivated' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDateActivated($value)
    {
        return $this->set(self::DATEACTIVATED, $value);
    }

    /**
     * Returns value of 'dateActivated' property
     *
     * @return string
     */
    public function getDateActivated()
    {
        $value = $this->get(self::DATEACTIVATED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'dateAdded' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDateAdded($value)
    {
        return $this->set(self::DATEADDED, $value);
    }

    /**
     * Returns value of 'dateAdded' property
     *
     * @return string
     */
    public function getDateAdded()
    {
        $value = $this->get(self::DATEADDED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'dateModified' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDateModified($value)
    {
        return $this->set(self::DATEMODIFIED, $value);
    }

    /**
     * Returns value of 'dateModified' property
     *
     * @return string
     */
    public function getDateModified()
    {
        $value = $this->get(self::DATEMODIFIED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'dateShipped' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDateShipped($value)
    {
        return $this->set(self::DATESHIPPED, $value);
    }

    /**
     * Returns value of 'dateShipped' property
     *
     * @return string
     */
    public function getDateShipped()
    {
        $value = $this->get(self::DATESHIPPED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'monthToDateDataUsage' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMonthToDateDataUsage($value)
    {
        return $this->set(self::MONTHTODATEDATAUSAGE, $value);
    }

    /**
     * Returns value of 'monthToDateDataUsage' property
     *
     * @return integer
     */
    public function getMonthToDateDataUsage()
    {
        $value = $this->get(self::MONTHTODATEDATAUSAGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'monthToDateSMSUsage' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMonthToDateSMSUsage($value)
    {
        return $this->set(self::MONTHTODATESMSUSAGE, $value);
    }

    /**
     * Returns value of 'monthToDateSMSUsage' property
     *
     * @return integer
     */
    public function getMonthToDateSMSUsage()
    {
        $value = $this->get(self::MONTHTODATESMSUSAGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'monthToDateVoiceUsage' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMonthToDateVoiceUsage($value)
    {
        return $this->set(self::MONTHTODATEVOICEUSAGE, $value);
    }

    /**
     * Returns value of 'monthToDateVoiceUsage' property
     *
     * @return integer
     */
    public function getMonthToDateVoiceUsage()
    {
        $value = $this->get(self::MONTHTODATEVOICEUSAGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'secureSimId' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSecureSimId($value)
    {
        return $this->set(self::SECURESIMID, $value);
    }

    /**
     * Returns value of 'secureSimId' property
     *
     * @return string
     */
    public function getSecureSimId()
    {
        $value = $this->get(self::SECURESIMID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom1' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom1($value)
    {
        return $this->set(self::CUSTOM1, $value);
    }

    /**
     * Returns value of 'custom1' property
     *
     * @return string
     */
    public function getCustom1()
    {
        $value = $this->get(self::CUSTOM1);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom2' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom2($value)
    {
        return $this->set(self::CUSTOM2, $value);
    }

    /**
     * Returns value of 'custom2' property
     *
     * @return string
     */
    public function getCustom2()
    {
        $value = $this->get(self::CUSTOM2);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom3' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom3($value)
    {
        return $this->set(self::CUSTOM3, $value);
    }

    /**
     * Returns value of 'custom3' property
     *
     * @return string
     */
    public function getCustom3()
    {
        $value = $this->get(self::CUSTOM3);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom4' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom4($value)
    {
        return $this->set(self::CUSTOM4, $value);
    }

    /**
     * Returns value of 'custom4' property
     *
     * @return string
     */
    public function getCustom4()
    {
        $value = $this->get(self::CUSTOM4);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom5' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom5($value)
    {
        return $this->set(self::CUSTOM5, $value);
    }

    /**
     * Returns value of 'custom5' property
     *
     * @return string
     */
    public function getCustom5()
    {
        $value = $this->get(self::CUSTOM5);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom6' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom6($value)
    {
        return $this->set(self::CUSTOM6, $value);
    }

    /**
     * Returns value of 'custom6' property
     *
     * @return string
     */
    public function getCustom6()
    {
        $value = $this->get(self::CUSTOM6);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom7' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom7($value)
    {
        return $this->set(self::CUSTOM7, $value);
    }

    /**
     * Returns value of 'custom7' property
     *
     * @return string
     */
    public function getCustom7()
    {
        $value = $this->get(self::CUSTOM7);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom8' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom8($value)
    {
        return $this->set(self::CUSTOM8, $value);
    }

    /**
     * Returns value of 'custom8' property
     *
     * @return string
     */
    public function getCustom8()
    {
        $value = $this->get(self::CUSTOM8);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom9' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom9($value)
    {
        return $this->set(self::CUSTOM9, $value);
    }

    /**
     * Returns value of 'custom9' property
     *
     * @return string
     */
    public function getCustom9()
    {
        $value = $this->get(self::CUSTOM9);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'custom10' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustom10($value)
    {
        return $this->set(self::CUSTOM10, $value);
    }

    /**
     * Returns value of 'custom10' property
     *
     * @return string
     */
    public function getCustom10()
    {
        $value = $this->get(self::CUSTOM10);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'rating' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\RatingInfo $value Property value
     *
     * @return null
     */
    public function setRating(\Mapgoo\Mlb\M2maas\Request\Data\RatingInfo $value=null)
    {
        return $this->set(self::RATING, $value);
    }

    /**
     * Returns value of 'rating' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\RatingInfo
     */
    public function getRating()
    {
        return $this->get(self::RATING);
    }

    /**
     * Sets value of 'secureSimUsernameCopyRule' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSecureSimUsernameCopyRule($value)
    {
        return $this->set(self::SECURESIMUSERNAMECOPYRULE, $value);
    }

    /**
     * Returns value of 'secureSimUsernameCopyRule' property
     *
     * @return string
     */
    public function getSecureSimUsernameCopyRule()
    {
        $value = $this->get(self::SECURESIMUSERNAMECOPYRULE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'secureSimPasswordCopyRule' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSecureSimPasswordCopyRule($value)
    {
        return $this->set(self::SECURESIMPASSWORDCOPYRULE, $value);
    }

    /**
     * Returns value of 'secureSimPasswordCopyRule' property
     *
     * @return string
     */
    public function getSecureSimPasswordCopyRule()
    {
        $value = $this->get(self::SECURESIMPASSWORDCOPYRULE);
        return $value === null ? (string)$value : $value;
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
     * Sets value of 'fixedIpAddress' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setFixedIpAddress($value)
    {
        return $this->set(self::FIXEDIPADDRESS, $value);
    }

    /**
     * Returns value of 'fixedIpAddress' property
     *
     * @return string
     */
    public function getFixedIpAddress()
    {
        $value = $this->get(self::FIXEDIPADDRESS);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'ctdSessionCount' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCtdSessionCount($value)
    {
        return $this->set(self::CTDSESSIONCOUNT, $value);
    }

    /**
     * Returns value of 'ctdSessionCount' property
     *
     * @return integer
     */
    public function getCtdSessionCount()
    {
        $value = $this->get(self::CTDSESSIONCOUNT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'customerCustom1' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustomerCustom1($value)
    {
        return $this->set(self::CUSTOMERCUSTOM1, $value);
    }

    /**
     * Returns value of 'customerCustom1' property
     *
     * @return string
     */
    public function getCustomerCustom1()
    {
        $value = $this->get(self::CUSTOMERCUSTOM1);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'customerCustom2' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustomerCustom2($value)
    {
        return $this->set(self::CUSTOMERCUSTOM2, $value);
    }

    /**
     * Returns value of 'customerCustom2' property
     *
     * @return string
     */
    public function getCustomerCustom2()
    {
        $value = $this->get(self::CUSTOMERCUSTOM2);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'customerCustom3' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustomerCustom3($value)
    {
        return $this->set(self::CUSTOMERCUSTOM3, $value);
    }

    /**
     * Returns value of 'customerCustom3' property
     *
     * @return string
     */
    public function getCustomerCustom3()
    {
        $value = $this->get(self::CUSTOMERCUSTOM3);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'customerCustom4' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustomerCustom4($value)
    {
        return $this->set(self::CUSTOMERCUSTOM4, $value);
    }

    /**
     * Returns value of 'customerCustom4' property
     *
     * @return string
     */
    public function getCustomerCustom4()
    {
        $value = $this->get(self::CUSTOMERCUSTOM4);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'customerCustom5' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCustomerCustom5($value)
    {
        return $this->set(self::CUSTOMERCUSTOM5, $value);
    }

    /**
     * Returns value of 'customerCustom5' property
     *
     * @return string
     */
    public function getCustomerCustom5()
    {
        $value = $this->get(self::CUSTOMERCUSTOM5);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'operatorCustom1' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOperatorCustom1($value)
    {
        return $this->set(self::OPERATORCUSTOM1, $value);
    }

    /**
     * Returns value of 'operatorCustom1' property
     *
     * @return string
     */
    public function getOperatorCustom1()
    {
        $value = $this->get(self::OPERATORCUSTOM1);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'operatorCustom2' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOperatorCustom2($value)
    {
        return $this->set(self::OPERATORCUSTOM2, $value);
    }

    /**
     * Returns value of 'operatorCustom2' property
     *
     * @return string
     */
    public function getOperatorCustom2()
    {
        $value = $this->get(self::OPERATORCUSTOM2);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'operatorCustom3' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOperatorCustom3($value)
    {
        return $this->set(self::OPERATORCUSTOM3, $value);
    }

    /**
     * Returns value of 'operatorCustom3' property
     *
     * @return string
     */
    public function getOperatorCustom3()
    {
        $value = $this->get(self::OPERATORCUSTOM3);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'operatorCustom4' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOperatorCustom4($value)
    {
        return $this->set(self::OPERATORCUSTOM4, $value);
    }

    /**
     * Returns value of 'operatorCustom4' property
     *
     * @return string
     */
    public function getOperatorCustom4()
    {
        $value = $this->get(self::OPERATORCUSTOM4);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'operatorCustom5' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOperatorCustom5($value)
    {
        return $this->set(self::OPERATORCUSTOM5, $value);
    }

    /**
     * Returns value of 'operatorCustom5' property
     *
     * @return string
     */
    public function getOperatorCustom5()
    {
        $value = $this->get(self::OPERATORCUSTOM5);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'imsi' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setImsi($value)
    {
        return $this->set(self::IMSI, $value);
    }

    /**
     * Returns value of 'imsi' property
     *
     * @return string
     */
    public function getImsi()
    {
        $value = $this->get(self::IMSI);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'primaryICCID' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPrimaryICCID($value)
    {
        return $this->set(self::PRIMARYICCID, $value);
    }

    /**
     * Returns value of 'primaryICCID' property
     *
     * @return string
     */
    public function getPrimaryICCID()
    {
        $value = $this->get(self::PRIMARYICCID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'imei' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setImei($value)
    {
        return $this->set(self::IMEI, $value);
    }

    /**
     * Returns value of 'imei' property
     *
     * @return string
     */
    public function getImei()
    {
        $value = $this->get(self::IMEI);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'globalSimType' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setGlobalSimType($value)
    {
        return $this->set(self::GLOBALSIMTYPE, $value);
    }

    /**
     * Returns value of 'globalSimType' property
     *
     * @return string
     */
    public function getGlobalSimType()
    {
        $value = $this->get(self::GLOBALSIMTYPE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'simNotes' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSimNotes($value)
    {
        return $this->set(self::SIMNOTES, $value);
    }

    /**
     * Returns value of 'simNotes' property
     *
     * @return string
     */
    public function getSimNotes()
    {
        $value = $this->get(self::SIMNOTES);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'version' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setVersion($value)
    {
        return $this->set(self::VERSION, $value);
    }

    /**
     * Returns value of 'version' property
     *
     * @return integer
     */
    public function getVersion()
    {
        $value = $this->get(self::VERSION);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'euiccid' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setEuiccid($value)
    {
        return $this->set(self::EUICCID, $value);
    }

    /**
     * Returns value of 'euiccid' property
     *
     * @return string
     */
    public function getEuiccid()
    {
        $value = $this->get(self::EUICCID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Sets value of 'msisdn' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMsisdn($value)
    {
        return $this->set(self::MSISDN, $value);
    }

    /**
     * Returns value of 'msisdn' property
     *
     * @return string
     */
    public function getMsisdn()
    {
        $value = $this->get(self::MSISDN);
        return $value === null ? (string)$value : $value;
    }
}
}