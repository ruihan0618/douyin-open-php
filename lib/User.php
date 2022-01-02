<?php

namespace VisionRhythm;

class User extends ApiResource
{
    /**
     * @param null $open_id
     * @param null $access_token
     * @return mixed
     * @throws Error\Api
     * @throws Error\InvalidRequest
     */
    public static function info($open_id = null, $access_token = null)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token ];
        return self::_userInfo($params);
    }

    public static function fans($open_id = null, $access_token = null, $cursor = 0, $count = 10)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token, 'cursor' => $cursor, 'count' => $count ];
        return self::_userFans($params);
    }

    public static function following($open_id = null, $access_token = null, $cursor = 0, $count = 10)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token, 'cursor' => $cursor, 'count' => $count ];
        return self::_userFollowings($params);
    }
}
