<?php

require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

/**
 * 授权链接
 */

$open_id = '';
$access_token = '';
try {

    $userInfo = \VisionRhythm\User::info($open_id, $access_token);
    echo($userInfo)."\r\n";

    $fans = \VisionRhythm\User::fans($open_id, $access_token, 0, 10);
    echo($fans)."\r\n";

    $following = \VisionRhythm\User::following($open_id, $access_token, 0, 10);
    echo($following)."\r\n";

} catch (\Visionrhythm\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
