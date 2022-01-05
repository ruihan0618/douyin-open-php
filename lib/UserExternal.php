<?php

namespace VisionRhythm;

/**
 * 数据开放-用户数据
 */
class UserExternal extends ApiResource
{

    /**
     * 获取用户视频情况
     * @param null $open_id
     * @param null $access_token
     * @param null $data_type
     * @return array|Util\stdObject|VisionrhythmObject
     */
    public static function video($open_id = null, $access_token = null, $data_type = 7)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token, 'data_type' => $data_type ];
        return self::_userExternalVideo($params);
    }

    /**
     * 获取用户粉丝数
     * @param null $open_id
     * @param null $access_token
     * @return mixed
     * @throws Error\Api
     * @throws Error\InvalidRequest
     */
    public static function fans($open_id = null, $access_token = null, $data_type = 7)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token, 'data_type' => $data_type ];
        return self::_userExternalFans($params);
    }


}
