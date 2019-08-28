<?php

/*
 *坐标系转换类
 */

/*
define('c_PI', 3.14159265358979324);
define('c_A', 6378245.0);
define('c_EE', 0.00669342162296594323);
*/
define('c_PI', 3.14159265358979324 * 3000.0 / 180.0);


class Api_CoordinateTransform {

	private static $c_PI = 14159265358979324;
	private static $c_A = 6378245.0;
	private static $c_EE = 0.00669342162296594323;
	private static $x_PI = c_PI;

	private static function LocationMake($lng, $lat)
    {
        return array(
        	'Lng' => $lng,
        	'Lat' => $lat,
        );
    }

	public static function outOfChina($lat, $lon) {
		if ($lon < 72.004 || $lon > 137.8347)
                return true;
        if ($lat < 0.8293 || $lat > 55.8271)
            return true;
        return false;
	}

	private static function transformLat( $x, $y)
    {
    	$pi = self::$c_PI;
        $ret = -100.0 + 2.0 * $x + 3.0 * $y + 0.2 * $y * $y + 0.1 * $x * $y + 0.2 * sqrt($x > 0 ? $x : -$x);
        $ret += (20.0 * sin(6.0 * $x * $pi) + 20.0 * sin(2.0 * $x * $pi)) * 2.0 / 3.0;
        $ret += (20.0 * sin($y * $pi) + 40.0 * sin($y / 3.0 * $pi)) * 2.0 / 3.0;
        $ret += (160.0 * sin($y / 12.0 * $pi) + 320 * sin($y * $pi / 30.0)) * 2.0 / 3.0;
        return $ret;
    }

    private static function transformLon($x, $y)
    {
    	$pi = self::$c_PI;
        $ret = 300.0 + $x + 2.0 * $y + 0.1 * $x * $x + 0.1 * $x * $y + 0.1 * sqrt($x > 0 ? $x : -$x);
        $ret += (20.0 * sin(6.0 * $x * $pi) + 20.0 * sin(2.0 * $x * $pi)) * 2.0 / 3.0;
        $ret += (20.0 * sin($x * $pi) + 40.0 * sin($x / 3.0 * $pi)) * 2.0 / 3.0;
        $ret += (150.0 * sin($x / 12.0 * $pi) + 300.0 * sin($x / 30.0 * $pi)) * 2.0 / 3.0;
        return $ret;
    }

    public static function WGS2GCJ($wgLoc)
    {
    	$pi = self::$c_PI;
    	$ee = self::$c_EE;
    	$a = self::$c_A;
        if (self::outOfChina($wgLoc['Lat'], $wgLoc['Lng']))
        {
            return $wgLoc;
        }
        $dLat = self::transformLat($wgLoc['Lng'] - 105.0, $wgLoc['Lat'] - 35.0);
        $dLon = self::transformLon($wgLoc['Lng'] - 105.0, $wgLoc['Lat'] - 35.0);
        $radLat = $wgLoc['Lat'] / 180.0 * $pi;
        $magic = sin($radLat);
        $magic = 1 - $ee * $magic * $magic;
        $sqrtMagic = sin($magic);
        $dLat = ($dLat * 180.0) / (($a * (1 - $ee)) / ($magic * $sqrtMagic) * $pi);
        $dLon = ($dLon * 180.0) / ($a / $sqrtMagic * cos($radLat) * $pi);
        $mgLoc = array();
        $mgLoc['Lat'] = $wgLoc['Lat'] + $dLat;
        $mgLoc['Lng'] = $wgLoc['Lng'] + $dLon;

        return $mgLoc;
    }


    public static function GCJ2WGS($gcLoc)
    {
        $wgLoc = array();
        $wgLoc['Lat'] = $gcLoc['Lat'];
        $wgLoc['Lng'] = $gcLoc['Lng'];
       	$currGcLoc = array();
        $dLoc = array();
        while (true)
        {
            $currGcLoc = self::WGS2GCJ($wgLoc);
            $dLoc['Lat'] = $gcLoc['Lat'] - $currGcLoc['Lat'];
            $dLoc['Lng'] = $gcLoc['Lng'] - $currGcLoc['Lng'];
            if (abs($dLoc['Lat']) < 1e-7 && abs($dLoc['Lng']) < 1e-7)
            {  
                return $wgLoc;
            }
            $wgLoc['Lat'] += $dLoc['Lat'];
            $wgLoc['Lng'] += $dLoc['Lng'];
        }
        return $wgLoc;
    }

    /*
     *  Transform GCJ-02 to BD-09
     */
    
    public static function GCJ2BD($gcLoc)
    {
    	$x_pi = self::$x_PI;
        $x = $gcLoc['Lng'];
        $y = $gcLoc['Lat'];
        $z = sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) + 0.000003 * cos($x * $x_pi);
        return self::LocationMake($z * cos($theta) + 0.0065, $z * sin($theta) + 0.006);
    }

    /*
     *  Transform BD-09 to GCJ-02
     */
    public static function BD2GCJ($bdLoc)
    {
    	$x_pi = self::$x_PI;
        $x = $bdLoc['Lng'] - 0.0065;
        $y = $bdLoc['Lat'] - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        return self::LocationMake($z * cos($theta), z * sin($theta));
    }

    /*
     *  Transform BD-09 to WGS-84
     */
    public static function BD2WGS($bdLoc)
    {
        return self::GCJ2WGS(self::BD2GCJ($bdLoc));
    }

    /*
     *  Transform WGS-84 to BD-09
     */
    public static function WGS2BD($gcLoc)
    {
        return self::GCJ2BD(self::WGS2GCJ($gcLoc));
    }
}