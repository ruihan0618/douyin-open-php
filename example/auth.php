<?php

require dirname(__FILE__) . '/../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/config.php';

/**
 * 授权链接
 */

$code = '094f1855e06dbcb2xxvp6egOJ81o9qG915lo';
try {
//    $scope = 'user_info,following.list,fans.list,video.create,video.delete,video.data,video.list,video.search,data.external.user,data.external.item';
//    $authUri = \Visionrhythm\Auth::connect($scope);
//    header('Location: '.$authUri);
//    echo $authUri;


   $response = \VisionRhythm\Auth::access($code);
   print_r($response);

} catch (\Visionrhythm\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
