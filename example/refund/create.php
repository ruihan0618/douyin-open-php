<?php

require dirname(__FILE__) . '/../../init.php';
// 示例配置文件，测试请根据文件注释修改其配置
require dirname(__FILE__) . '/../config.php';


// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$input_data = json_decode(file_get_contents('php://input'), true);

$orderNo = substr(md5(time()), 0, 18);
try {
    $refund = \Visionrhythm\Refund::create(
        'ch_d487b7672801426fac2344d3',
        ['amount' => '0.01', 'description' =>'Refund Description']
    );
    echo $refund;                                       // 输出 返回的支付凭据 Auth
} catch (\Visionrhythm\Error\Base $e) {
    // 捕获报错信息
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}
