<?php

require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

/**
 * 授权链接
 */

$open_id = '05bd883b-98fb-48df-80b5-30cd8e088112';
$access_token = 'act.fe4d3300a0df6d02be5c78bfcf722efddEnRoSM8SjQ25igBwbYmQH8dDpvS';
try {

//    $userInfo = \VisionRhythm\User::info($open_id, $access_token);
//    echo($userInfo)."\r\n";
//
//    $fans = \VisionRhythm\User::fans($open_id, $access_token, 0, 10);
//    echo($fans)."\r\n";
//
//    $following = \VisionRhythm\User::following($open_id, $access_token, 0, 10);
//    echo($following)."\r\n";
//

//      $externalFans = \VisionRhythm\UserExternal::fans($open_id, $access_token, 7);
//      echo $externalFans." \r\n";

      $externalVideos = \VisionRhythm\UserExternal::video($open_id, $access_token, 7);
      echo $externalVideos." \r\n";


} catch (\Visionrhythm\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
