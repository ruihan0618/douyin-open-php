<?php

namespace VisionRhythm;

class AppBase extends ApiResource
{
    /**
     * @return string
     * @throws Error\InvalidRequest
     */
    public static function appBaseUrl()
    {
        if (VisionRhythm::$clientSecret === null) {
            throw new Error\InvalidRequest(
                'Please set a global app ID by VisionRhythm::setAppId(<clientId>)',
                null
            );
        }
        $appId = Util\Util::utf8(VisionRhythm::$clientSecret);
        return "/v1/apps/${appId}";
    }

    /**
     * @return string
     * @throws Error\InvalidRequest
     */
    public static function classUrl()
    {
        $base = static::appBaseUrl();
        $resourceName = static::className();
        return "${base}/${resourceName}s";
    }
}
