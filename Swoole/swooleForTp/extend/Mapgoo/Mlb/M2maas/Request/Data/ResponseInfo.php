<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * ResponseInfo message
 */
class ResponseInfo extends \ProtobufMessage
{
    /* Field index constants */
    const BASEINFO = 1;
    const TERMINALEDITRESP = 2;
    const GETTERMINALDETAILRESP = 3;
    const QUEUETERMINALRATEPLANRESP = 4;
    const EDITTERMINALRATINGRESP = 5;
    const GETSESSIONINFORESP = 6;
    const GETMODIFIEDTERMINALSRESP = 7;
    const GETTERMINALRATINGRESP = 8;
    const GETTERMINALAUDITTRAILRESP = 9;
    const GETNETWORKACCESSCONFIGRESP = 10;
    const EDITNETWORKACCESSCONFIGRESP = 11;
    const GETTERMINALUSAGEDATADETAILSRESP = 12;
    const GETTERMINALUSAGERESP = 13;
    const SENDSMSRESP = 14;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::BASEINFO => array(
            'name' => 'baseInfo',
            'required' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\ResponseBaseInfo'
        ),
        self::TERMINALEDITRESP => array(
            'name' => 'terminalEditResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\TerminalEditResp'
        ),
        self::GETTERMINALDETAILRESP => array(
            'name' => 'getTerminalDetailResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailResp'
        ),
        self::QUEUETERMINALRATEPLANRESP => array(
            'name' => 'queueTerminalRatePlanResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanResp'
        ),
        self::EDITTERMINALRATINGRESP => array(
            'name' => 'editTerminalRatingResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingResp'
        ),
        self::GETSESSIONINFORESP => array(
            'name' => 'getSessionInfoResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoResp'
        ),
        self::GETMODIFIEDTERMINALSRESP => array(
            'name' => 'getModifiedTerminalsResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsResp'
        ),
        self::GETTERMINALRATINGRESP => array(
            'name' => 'getTerminalRatingResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingResp'
        ),
        self::GETTERMINALAUDITTRAILRESP => array(
            'name' => 'getTerminalAuditTrailResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailResp'
        ),
        self::GETNETWORKACCESSCONFIGRESP => array(
            'name' => 'getNetworkAccessConfigResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigResp'
        ),
        self::EDITNETWORKACCESSCONFIGRESP => array(
            'name' => 'editNetworkAccessConfigResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigResp'
        ),
        self::GETTERMINALUSAGEDATADETAILSRESP => array(
            'name' => 'getTerminalUsageDataDetailsResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsResp'
        ),
        self::GETTERMINALUSAGERESP => array(
            'name' => 'getTerminalUsageResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageResp'
        ),
        self::SENDSMSRESP => array(
            'name' => 'sendSmsResp',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\SendSmsResp'
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
        $this->values[self::BASEINFO] = null;
        $this->values[self::TERMINALEDITRESP] = null;
        $this->values[self::GETTERMINALDETAILRESP] = null;
        $this->values[self::QUEUETERMINALRATEPLANRESP] = null;
        $this->values[self::EDITTERMINALRATINGRESP] = null;
        $this->values[self::GETSESSIONINFORESP] = null;
        $this->values[self::GETMODIFIEDTERMINALSRESP] = null;
        $this->values[self::GETTERMINALRATINGRESP] = null;
        $this->values[self::GETTERMINALAUDITTRAILRESP] = null;
        $this->values[self::GETNETWORKACCESSCONFIGRESP] = null;
        $this->values[self::EDITNETWORKACCESSCONFIGRESP] = null;
        $this->values[self::GETTERMINALUSAGEDATADETAILSRESP] = null;
        $this->values[self::GETTERMINALUSAGERESP] = null;
        $this->values[self::SENDSMSRESP] = null;
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
     * Sets value of 'baseInfo' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\ResponseBaseInfo $value Property value
     *
     * @return null
     */
    public function setBaseInfo(\Mapgoo\Mlb\M2maas\Request\Data\ResponseBaseInfo $value=null)
    {
        return $this->set(self::BASEINFO, $value);
    }

    /**
     * Returns value of 'baseInfo' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\ResponseBaseInfo
     */
    public function getBaseInfo()
    {
        return $this->get(self::BASEINFO);
    }

    /**
     * Sets value of 'terminalEditResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\TerminalEditResp $value Property value
     *
     * @return null
     */
    public function setTerminalEditResp(\Mapgoo\Mlb\M2maas\Request\Data\TerminalEditResp $value=null)
    {
        return $this->set(self::TERMINALEDITRESP, $value);
    }

    /**
     * Returns value of 'terminalEditResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalEditResp
     */
    public function getTerminalEditResp()
    {
        return $this->get(self::TERMINALEDITRESP);
    }

    /**
     * Sets value of 'getTerminalDetailResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailResp $value Property value
     *
     * @return null
     */
    public function setGetTerminalDetailResp(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailResp $value=null)
    {
        return $this->set(self::GETTERMINALDETAILRESP, $value);
    }

    /**
     * Returns value of 'getTerminalDetailResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailResp
     */
    public function getGetTerminalDetailResp()
    {
        return $this->get(self::GETTERMINALDETAILRESP);
    }

    /**
     * Sets value of 'queueTerminalRatePlanResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanResp $value Property value
     *
     * @return null
     */
    public function setQueueTerminalRatePlanResp(\Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanResp $value=null)
    {
        return $this->set(self::QUEUETERMINALRATEPLANRESP, $value);
    }

    /**
     * Returns value of 'queueTerminalRatePlanResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanResp
     */
    public function getQueueTerminalRatePlanResp()
    {
        return $this->get(self::QUEUETERMINALRATEPLANRESP);
    }

    /**
     * Sets value of 'editTerminalRatingResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingResp $value Property value
     *
     * @return null
     */
    public function setEditTerminalRatingResp(\Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingResp $value=null)
    {
        return $this->set(self::EDITTERMINALRATINGRESP, $value);
    }

    /**
     * Returns value of 'editTerminalRatingResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingResp
     */
    public function getEditTerminalRatingResp()
    {
        return $this->get(self::EDITTERMINALRATINGRESP);
    }

    /**
     * Sets value of 'getSessionInfoResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoResp $value Property value
     *
     * @return null
     */
    public function setGetSessionInfoResp(\Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoResp $value=null)
    {
        return $this->set(self::GETSESSIONINFORESP, $value);
    }

    /**
     * Returns value of 'getSessionInfoResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoResp
     */
    public function getGetSessionInfoResp()
    {
        return $this->get(self::GETSESSIONINFORESP);
    }

    /**
     * Sets value of 'getModifiedTerminalsResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsResp $value Property value
     *
     * @return null
     */
    public function setGetModifiedTerminalsResp(\Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsResp $value=null)
    {
        return $this->set(self::GETMODIFIEDTERMINALSRESP, $value);
    }

    /**
     * Returns value of 'getModifiedTerminalsResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsResp
     */
    public function getGetModifiedTerminalsResp()
    {
        return $this->get(self::GETMODIFIEDTERMINALSRESP);
    }

    /**
     * Sets value of 'getTerminalRatingResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingResp $value Property value
     *
     * @return null
     */
    public function setGetTerminalRatingResp(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingResp $value=null)
    {
        return $this->set(self::GETTERMINALRATINGRESP, $value);
    }

    /**
     * Returns value of 'getTerminalRatingResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingResp
     */
    public function getGetTerminalRatingResp()
    {
        return $this->get(self::GETTERMINALRATINGRESP);
    }

    /**
     * Sets value of 'getTerminalAuditTrailResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailResp $value Property value
     *
     * @return null
     */
    public function setGetTerminalAuditTrailResp(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailResp $value=null)
    {
        return $this->set(self::GETTERMINALAUDITTRAILRESP, $value);
    }

    /**
     * Returns value of 'getTerminalAuditTrailResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailResp
     */
    public function getGetTerminalAuditTrailResp()
    {
        return $this->get(self::GETTERMINALAUDITTRAILRESP);
    }

    /**
     * Sets value of 'getNetworkAccessConfigResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigResp $value Property value
     *
     * @return null
     */
    public function setGetNetworkAccessConfigResp(\Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigResp $value=null)
    {
        return $this->set(self::GETNETWORKACCESSCONFIGRESP, $value);
    }

    /**
     * Returns value of 'getNetworkAccessConfigResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigResp
     */
    public function getGetNetworkAccessConfigResp()
    {
        return $this->get(self::GETNETWORKACCESSCONFIGRESP);
    }

    /**
     * Sets value of 'editNetworkAccessConfigResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigResp $value Property value
     *
     * @return null
     */
    public function setEditNetworkAccessConfigResp(\Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigResp $value=null)
    {
        return $this->set(self::EDITNETWORKACCESSCONFIGRESP, $value);
    }

    /**
     * Returns value of 'editNetworkAccessConfigResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigResp
     */
    public function getEditNetworkAccessConfigResp()
    {
        return $this->get(self::EDITNETWORKACCESSCONFIGRESP);
    }

    /**
     * Sets value of 'getTerminalUsageDataDetailsResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsResp $value Property value
     *
     * @return null
     */
    public function setGetTerminalUsageDataDetailsResp(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsResp $value=null)
    {
        return $this->set(self::GETTERMINALUSAGEDATADETAILSRESP, $value);
    }

    /**
     * Returns value of 'getTerminalUsageDataDetailsResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsResp
     */
    public function getGetTerminalUsageDataDetailsResp()
    {
        return $this->get(self::GETTERMINALUSAGEDATADETAILSRESP);
    }

    /**
     * Sets value of 'getTerminalUsageResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageResp $value Property value
     *
     * @return null
     */
    public function setGetTerminalUsageResp(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageResp $value=null)
    {
        return $this->set(self::GETTERMINALUSAGERESP, $value);
    }

    /**
     * Returns value of 'getTerminalUsageResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageResp
     */
    public function getGetTerminalUsageResp()
    {
        return $this->get(self::GETTERMINALUSAGERESP);
    }

    /**
     * Sets value of 'sendSmsResp' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\SendSmsResp $value Property value
     *
     * @return null
     */
    public function setSendSmsResp(\Mapgoo\Mlb\M2maas\Request\Data\SendSmsResp $value=null)
    {
        return $this->set(self::SENDSMSRESP, $value);
    }

    /**
     * Returns value of 'sendSmsResp' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\SendSmsResp
     */
    public function getSendSmsResp()
    {
        return $this->get(self::SENDSMSRESP);
    }
}
}