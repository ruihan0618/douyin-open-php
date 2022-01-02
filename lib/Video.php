<?php

namespace VisionRhythm;

class Video extends ApiResource
{

    /**
     * 上传视频
     * @param null $open_id
     * @param null $access_token
     * @param array $video
     * @return array|Util\stdObject|VisionrhythmObject
     */
    public static function upload($open_id = null, $access_token = null, $video = null)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token];
        return self::_videoUpload($params, ['video' => $video]);
    }

    /**
     * 创建视频
     * @param null $open_id
     * @param null $access_token
     * @param null $options
     * @return array|Util\stdObject|VisionrhythmObject
     */
    public static function create($open_id = null, $access_token = null, $options = null)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token];
        return self::_videoCreate($params, $options);
    }

    /**
     * 删除视频
     * @param null $open_id
     * @param null $access_token
     * @param null $item_id
     * @return array|Util\stdObject|VisionrhythmObject
     */
    public static function delete($open_id = null, $access_token = null, $item_id = null)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token];
        return self::_videoDelete($params, ['item_id' => $item_id]);
    }

    /**
     * 视频列表
     * @param null $open_id
     * @param null $access_token
     * @param int $cursor
     * @param int $count
     * @return array|Util\stdObject|VisionrhythmObject
     */
    public static function aweme($open_id = null, $access_token = null, $cursor = 0, $count = 10)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token, 'cursor' => $cursor, 'count' => $count];
        return self::_videoList($params);
    }

    /**
     * 查询指定视频数据
     * @param null $open_id
     * @param null $access_token
     * @param null $item_ids
     * @return mixed
     */
    public static function detail($open_id = null, $access_token = null, $item_ids = null)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token];
        return self::_videoData($params, ['item_ids' => $item_ids]);
    }

    public static function comment($open_id = null, $access_token = null, $item_id = null, $sort = 'time', $cursor = 0, $count = 10)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token, 'item_id' => $item_id, 'sort_type' => $sort, 'cursor' =>$cursor, 'count' => $count];
        return self::_videoItemComment($params);
    }
    /**
     * 关键词搜索
     * @param null $open_id
     * @param null $access_token
     * @param null $keyword
     * @param int $cursor
     * @param int $count
     * @return array|Util\stdObject|VisionrhythmObject
     */
    public static function search($open_id = null, $access_token = null, $keyword = null, $cursor = 0, $count = 10)
    {
        $params = ['open_id'=> $open_id, 'access_token'=> $access_token, 'keyword' => $keyword,'cursor' => $cursor, 'count' => $count];
        return self::_videoSearch($params);
    }
}
