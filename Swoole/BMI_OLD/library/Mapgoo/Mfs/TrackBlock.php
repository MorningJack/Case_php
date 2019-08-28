<?php
/**
 * Auto generated from mfs.proto at 2018-03-14 10:38:25
 *
 * mapgoo.mfs package
 */

namespace Mapgoo\Mfs {
/**
 * TrackBlock message
 */
class TrackBlock extends \ProtobufMessage
{
    /* Field index constants */
    const GPSTIME = 1;
    const LON = 2;
    const LAT = 3;
    const ACCURACYTYPE = 4;
    const MILEAGE = 5;
    const SPEED = 6;
    const DIRECT = 7;
    const ALTITUDE = 8;
    const GPSSATELITENUM = 9;
    const BEIDOUSATELITENUM = 10;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GPSTIME => array(
            'name' => 'gpsTime',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LON => array(
            'name' => 'lon',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LAT => array(
            'name' => 'lat',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACCURACYTYPE => array(
            'name' => 'accuracyType',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MILEAGE => array(
            'name' => 'mileage',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SPEED => array(
            'name' => 'speed',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DIRECT => array(
            'name' => 'direct',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ALTITUDE => array(
            'name' => 'altitude',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GPSSATELITENUM => array(
            'name' => 'gpsSateliteNum',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BEIDOUSATELITENUM => array(
            'name' => 'beidouSateliteNum',
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
        $this->values[self::GPSTIME] = null;
        $this->values[self::LON] = null;
        $this->values[self::LAT] = null;
        $this->values[self::ACCURACYTYPE] = null;
        $this->values[self::MILEAGE] = null;
        $this->values[self::SPEED] = null;
        $this->values[self::DIRECT] = null;
        $this->values[self::ALTITUDE] = null;
        $this->values[self::GPSSATELITENUM] = null;
        $this->values[self::BEIDOUSATELITENUM] = null;
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
     * Sets value of 'gpsTime' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGpsTime($value)
    {
        return $this->set(self::GPSTIME, $value);
    }

    /**
     * Returns value of 'gpsTime' property
     *
     * @return integer
     */
    public function getGpsTime()
    {
        $value = $this->get(self::GPSTIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'lon' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLon($value)
    {
        return $this->set(self::LON, $value);
    }

    /**
     * Returns value of 'lon' property
     *
     * @return integer
     */
    public function getLon()
    {
        $value = $this->get(self::LON);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'lat' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLat($value)
    {
        return $this->set(self::LAT, $value);
    }

    /**
     * Returns value of 'lat' property
     *
     * @return integer
     */
    public function getLat()
    {
        $value = $this->get(self::LAT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'accuracyType' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAccuracyType($value)
    {
        return $this->set(self::ACCURACYTYPE, $value);
    }

    /**
     * Returns value of 'accuracyType' property
     *
     * @return integer
     */
    public function getAccuracyType()
    {
        $value = $this->get(self::ACCURACYTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'mileage' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMileage($value)
    {
        return $this->set(self::MILEAGE, $value);
    }

    /**
     * Returns value of 'mileage' property
     *
     * @return integer
     */
    public function getMileage()
    {
        $value = $this->get(self::MILEAGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'speed' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSpeed($value)
    {
        return $this->set(self::SPEED, $value);
    }

    /**
     * Returns value of 'speed' property
     *
     * @return integer
     */
    public function getSpeed()
    {
        $value = $this->get(self::SPEED);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'direct' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDirect($value)
    {
        return $this->set(self::DIRECT, $value);
    }

    /**
     * Returns value of 'direct' property
     *
     * @return integer
     */
    public function getDirect()
    {
        $value = $this->get(self::DIRECT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'altitude' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAltitude($value)
    {
        return $this->set(self::ALTITUDE, $value);
    }

    /**
     * Returns value of 'altitude' property
     *
     * @return integer
     */
    public function getAltitude()
    {
        $value = $this->get(self::ALTITUDE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'gpsSateliteNum' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGpsSateliteNum($value)
    {
        return $this->set(self::GPSSATELITENUM, $value);
    }

    /**
     * Returns value of 'gpsSateliteNum' property
     *
     * @return integer
     */
    public function getGpsSateliteNum()
    {
        $value = $this->get(self::GPSSATELITENUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Sets value of 'beidouSateliteNum' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBeidouSateliteNum($value)
    {
        return $this->set(self::BEIDOUSATELITENUM, $value);
    }

    /**
     * Returns value of 'beidouSateliteNum' property
     *
     * @return integer
     */
    public function getBeidouSateliteNum()
    {
        $value = $this->get(self::BEIDOUSATELITENUM);
        return $value === null ? (integer)$value : $value;
    }
}
}