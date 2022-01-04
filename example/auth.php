<?php

require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

/**
 * 授权链接
 */

$code = 'b665a0958196ea88r7RydgPdSfcjxtP2YlBU';
try {
    //,following.list,fans.list,video.create,video.delete,video.data,video.list,video.search,data.external.user,data.external.item
//    $scope = 'user_info';
//    $authUri = \Visionrhythm\Auth::connect($scope);
//    header('Location: '.$authUri);
//    echo $authUri;


   $response = \VisionRhythm\Auth::access($code);
   echo($response)."\r\n";

} catch (\Visionrhythm\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
