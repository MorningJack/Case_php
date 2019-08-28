<?php
/**
 * Auto generated from mfs.proto at 2018-03-14 10:38:25
 *
 * mapgoo.mfs package
 */

namespace Mapgoo\Mfs {
/**
 * LocationType enum
 */
final class LocationType
{
    const LT_ACCURACY_GPS = 0;
    const LT_NOACCURACY_GPS = 1;
    const LT_BS = 2;
    const LT_WIFI = 3;
    const LT_MIXED = 4;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'LT_ACCURACY_GPS' => self::LT_ACCURACY_GPS,
            'LT_NOACCURACY_GPS' => self::LT_NOACCURACY_GPS,
            'LT_BS' => self::LT_BS,
            'LT_WIFI' => self::LT_WIFI,
            'LT_MIXED' => self::LT_MIXED,
        );
    }
}
}