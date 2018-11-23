<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * RequestInfo message
 */
class RequestInfo extends \ProtobufMessage
{
    /* Field index constants */
    const BASEINFO = 1;
    const TERMINALEDITREQ = 2;
    const GETTERMINALDETAILREQ = 3;
    const QUEUETERMINALRATEPLANREQ = 4;
    const EDITTERMINALRATINGREQ = 5;
    const GETSESSIONINFOREQ = 6;
    const GETMODIFIEDTERMINALSREQ = 7;
    const GETTERMINALRATINGREQ = 8;
    const GETTERMINALAUDITTRAILREQ = 9;
    const GETNETWORKACCESSCONFIGREQ = 10;
    const EDITNETWORKACCESSCONFIGREQ = 11;
    const GETTERMINALUSAGEDATADETAILSREQ = 12;
    const GETTERMINALUSAGEREQ = 13;
    const SENDSMSREQ = 14;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::BASEINFO => array(
            'name' => 'baseInfo',
            'required' => true,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\RequestBaseInfo'
        ),
        self::TERMINALEDITREQ => array(
            'name' => 'terminalEditReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\TerminalEditReq'
        ),
        self::GETTERMINALDETAILREQ => array(
            'name' => 'getTerminalDetailReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailReq'
        ),
        self::QUEUETERMINALRATEPLANREQ => array(
            'name' => 'queueTerminalRatePlanReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanReq'
        ),
        self::EDITTERMINALRATINGREQ => array(
            'name' => 'editTerminalRatingReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingReq'
        ),
        self::GETSESSIONINFOREQ => array(
            'name' => 'getSessionInfoReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoReq'
        ),
        self::GETMODIFIEDTERMINALSREQ => array(
            'name' => 'getModifiedTerminalsReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsReq'
        ),
        self::GETTERMINALRATINGREQ => array(
            'name' => 'getTerminalRatingReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingReq'
        ),
        self::GETTERMINALAUDITTRAILREQ => array(
            'name' => 'getTerminalAuditTrailReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailReq'
        ),
        self::GETNETWORKACCESSCONFIGREQ => array(
            'name' => 'getNetworkAccessConfigReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigReq'
        ),
        self::EDITNETWORKACCESSCONFIGREQ => array(
            'name' => 'editNetworkAccessConfigReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigReq'
        ),
        self::GETTERMINALUSAGEDATADETAILSREQ => array(
            'name' => 'getTerminalUsageDataDetailsReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsReq'
        ),
        self::GETTERMINALUSAGEREQ => array(
            'name' => 'getTerminalUsageReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageReq'
        ),
        self::SENDSMSREQ => array(
            'name' => 'sendSmsReq',
            'required' => false,
            'type' => '\Mapgoo\Mlb\M2maas\Request\Data\SendSmsReq'
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
        $this->values[self::TERMINALEDITREQ] = null;
        $this->values[self::GETTERMINALDETAILREQ] = null;
        $this->values[self::QUEUETERMINALRATEPLANREQ] = null;
        $this->values[self::EDITTERMINALRATINGREQ] = null;
        $this->values[self::GETSESSIONINFOREQ] = null;
        $this->values[self::GETMODIFIEDTERMINALSREQ] = null;
        $this->values[self::GETTERMINALRATINGREQ] = null;
        $this->values[self::GETTERMINALAUDITTRAILREQ] = null;
        $this->values[self::GETNETWORKACCESSCONFIGREQ] = null;
        $this->values[self::EDITNETWORKACCESSCONFIGREQ] = null;
        $this->values[self::GETTERMINALUSAGEDATADETAILSREQ] = null;
        $this->values[self::GETTERMINALUSAGEREQ] = null;
        $this->values[self::SENDSMSREQ] = null;
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
     * @param \Mapgoo\Mlb\M2maas\Request\Data\RequestBaseInfo $value Property value
     *
     * @return null
     */
    public function setBaseInfo(\Mapgoo\Mlb\M2maas\Request\Data\RequestBaseInfo $value=null)
    {
        return $this->set(self::BASEINFO, $value);
    }

    /**
     * Returns value of 'baseInfo' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\RequestBaseInfo
     */
    public function getBaseInfo()
    {
        return $this->get(self::BASEINFO);
    }

    /**
     * Sets value of 'terminalEditReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\TerminalEditReq $value Property value
     *
     * @return null
     */
    public function setTerminalEditReq(\Mapgoo\Mlb\M2maas\Request\Data\TerminalEditReq $value=null)
    {
        return $this->set(self::TERMINALEDITREQ, $value);
    }

    /**
     * Returns value of 'terminalEditReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\TerminalEditReq
     */
    public function getTerminalEditReq()
    {
        return $this->get(self::TERMINALEDITREQ);
    }

    /**
     * Sets value of 'getTerminalDetailReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailReq $value Property value
     *
     * @return null
     */
    public function setGetTerminalDetailReq(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailReq $value=null)
    {
        return $this->set(self::GETTERMINALDETAILREQ, $value);
    }

    /**
     * Returns value of 'getTerminalDetailReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalDetailReq
     */
    public function getGetTerminalDetailReq()
    {
        return $this->get(self::GETTERMINALDETAILREQ);
    }

    /**
     * Sets value of 'queueTerminalRatePlanReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanReq $value Property value
     *
     * @return null
     */
    public function setQueueTerminalRatePlanReq(\Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanReq $value=null)
    {
        return $this->set(self::QUEUETERMINALRATEPLANREQ, $value);
    }

    /**
     * Returns value of 'queueTerminalRatePlanReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\QueueTerminalRatePlanReq
     */
    public function getQueueTerminalRatePlanReq()
    {
        return $this->get(self::QUEUETERMINALRATEPLANREQ);
    }

    /**
     * Sets value of 'editTerminalRatingReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingReq $value Property value
     *
     * @return null
     */
    public function setEditTerminalRatingReq(\Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingReq $value=null)
    {
        return $this->set(self::EDITTERMINALRATINGREQ, $value);
    }

    /**
     * Returns value of 'editTerminalRatingReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\EditTerminalRatingReq
     */
    public function getEditTerminalRatingReq()
    {
        return $this->get(self::EDITTERMINALRATINGREQ);
    }

    /**
     * Sets value of 'getSessionInfoReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoReq $value Property value
     *
     * @return null
     */
    public function setGetSessionInfoReq(\Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoReq $value=null)
    {
        return $this->set(self::GETSESSIONINFOREQ, $value);
    }

    /**
     * Returns value of 'getSessionInfoReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetSessionInfoReq
     */
    public function getGetSessionInfoReq()
    {
        return $this->get(self::GETSESSIONINFOREQ);
    }

    /**
     * Sets value of 'getModifiedTerminalsReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsReq $value Property value
     *
     * @return null
     */
    public function setGetModifiedTerminalsReq(\Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsReq $value=null)
    {
        return $this->set(self::GETMODIFIEDTERMINALSREQ, $value);
    }

    /**
     * Returns value of 'getModifiedTerminalsReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetModifiedTerminalsReq
     */
    public function getGetModifiedTerminalsReq()
    {
        return $this->get(self::GETMODIFIEDTERMINALSREQ);
    }

    /**
     * Sets value of 'getTerminalRatingReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingReq $value Property value
     *
     * @return null
     */
    public function setGetTerminalRatingReq(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingReq $value=null)
    {
        return $this->set(self::GETTERMINALRATINGREQ, $value);
    }

    /**
     * Returns value of 'getTerminalRatingReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalRatingReq
     */
    public function getGetTerminalRatingReq()
    {
        return $this->get(self::GETTERMINALRATINGREQ);
    }

    /**
     * Sets value of 'getTerminalAuditTrailReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailReq $value Property value
     *
     * @return null
     */
    public function setGetTerminalAuditTrailReq(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailReq $value=null)
    {
        return $this->set(self::GETTERMINALAUDITTRAILREQ, $value);
    }

    /**
     * Returns value of 'getTerminalAuditTrailReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalAuditTrailReq
     */
    public function getGetTerminalAuditTrailReq()
    {
        return $this->get(self::GETTERMINALAUDITTRAILREQ);
    }

    /**
     * Sets value of 'getNetworkAccessConfigReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigReq $value Property value
     *
     * @return null
     */
    public function setGetNetworkAccessConfigReq(\Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigReq $value=null)
    {
        return $this->set(self::GETNETWORKACCESSCONFIGREQ, $value);
    }

    /**
     * Returns value of 'getNetworkAccessConfigReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetNetworkAccessConfigReq
     */
    public function getGetNetworkAccessConfigReq()
    {
        return $this->get(self::GETNETWORKACCESSCONFIGREQ);
    }

    /**
     * Sets value of 'editNetworkAccessConfigReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigReq $value Property value
     *
     * @return null
     */
    public function setEditNetworkAccessConfigReq(\Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigReq $value=null)
    {
        return $this->set(self::EDITNETWORKACCESSCONFIGREQ, $value);
    }

    /**
     * Returns value of 'editNetworkAccessConfigReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\EditNetworkAccessConfigReq
     */
    public function getEditNetworkAccessConfigReq()
    {
        return $this->get(self::EDITNETWORKACCESSCONFIGREQ);
    }

    /**
     * Sets value of 'getTerminalUsageDataDetailsReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsReq $value Property value
     *
     * @return null
     */
    public function setGetTerminalUsageDataDetailsReq(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsReq $value=null)
    {
        return $this->set(self::GETTERMINALUSAGEDATADETAILSREQ, $value);
    }

    /**
     * Returns value of 'getTerminalUsageDataDetailsReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageDataDetailsReq
     */
    public function getGetTerminalUsageDataDetailsReq()
    {
        return $this->get(self::GETTERMINALUSAGEDATADETAILSREQ);
    }

    /**
     * Sets value of 'getTerminalUsageReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageReq $value Property value
     *
     * @return null
     */
    public function setGetTerminalUsageReq(\Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageReq $value=null)
    {
        return $this->set(self::GETTERMINALUSAGEREQ, $value);
    }

    /**
     * Returns value of 'getTerminalUsageReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\GetTerminalUsageReq
     */
    public function getGetTerminalUsageReq()
    {
        return $this->get(self::GETTERMINALUSAGEREQ);
    }

    /**
     * Sets value of 'sendSmsReq' property
     *
     * @param \Mapgoo\Mlb\M2maas\Request\Data\SendSmsReq $value Property value
     *
     * @return null
     */
    public function setSendSmsReq(\Mapgoo\Mlb\M2maas\Request\Data\SendSmsReq $value=null)
    {
        return $this->set(self::SENDSMSREQ, $value);
    }

    /**
     * Returns value of 'sendSmsReq' property
     *
     * @return \Mapgoo\Mlb\M2maas\Request\Data\SendSmsReq
     */
    public function getSendSmsReq()
    {
        return $this->get(self::SENDSMSREQ);
    }
}
}