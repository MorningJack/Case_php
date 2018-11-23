<?php
/**
 * Auto generated from m2maas.proto at 2018-07-02 09:18:05
 *
 * mapgoo.mlb.m2maas.request.data package
 */

namespace Mapgoo\Mlb\M2maas\Request\Data {
/**
 * SimStateType enum
 */
final class SimStateType
{
    const SimStateType_ACTIVATIONREADY = 0;
    const SimStateType_ACTIVATED = 1;
    const SimStateType_DEACTIVATED = 2;
    const SimStateType_PURGED = 3;
    const SimStateType_UNKNOWN = 4;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'SimStateType_ACTIVATIONREADY' => self::SimStateType_ACTIVATIONREADY,
            'SimStateType_ACTIVATED' => self::SimStateType_ACTIVATED,
            'SimStateType_DEACTIVATED' => self::SimStateType_DEACTIVATED,
            'SimStateType_PURGED' => self::SimStateType_PURGED,
            'SimStateType_UNKNOWN' => self::SimStateType_UNKNOWN,
        );
    }
}
}