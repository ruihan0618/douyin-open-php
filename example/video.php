<?php

require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

/**
 * 授权链接
 */

$open_id = '05bd883b-98fb-48df-80b5-30cd8e088112';
$access_token = 'act.cd58e33b00f6dc1f7812db386f3bc923ajCeiOZIpnh1ZYQcoT572mjYeYch';
$video_id = 'v0200f450000bn8c6aa0ifki8fikg1b0';
$item_id = '@8hxdhauTCMppanGnM4ltGM780mDqPP+KPpR0qQOmLVAXb/T060zdRmYqig357zEBq6CZRp4NVe6qLIJW/V/x1w==';
$keyword = '方太';
try {

    //上传视频
//    $upload = \VisionRhythm\Video::upload($open_id, $access_token, @'C:\Users\Administrator\Desktop\1080\abc.mp4');
//    echo($upload)."\r\n";

    //创建视频
//    $options = ['video_id' => $video_id, 'text' => '沙箱环境测试'];
//    $create = \VisionRhythm\Video::create($open_id, $access_token, $options);
//    echo($create)."\r\n";

//    //删除视频
//    $delete = \VisionRhythm\Video::delete($open_id, $access_token, $item_id);
//    echo $delete."\r\n";

    //视频列表
//    $list = \VisionRhythm\Video::aweme($open_id, $access_token, 0, 10);
//    echo($list)."\r\n";
//
      // 视频详情
//    $detail = \VisionRhythm\Video::detail($open_id, $access_token, [$item_id]);
//    echo($detail)."\r\n";

    //关键词搜索
//      $search = \VisionRhythm\Video::search($open_id, $access_token, $keyword, 0, 10);
//      echo($search)."\r\n";

    //视频评论列表
      $comment = \VisionRhythm\Video::comment($open_id, $access_token, $item_id, 'time', 0, 10);
      echo($comment)."\r\n";



} catch (\Visionrhythm\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
