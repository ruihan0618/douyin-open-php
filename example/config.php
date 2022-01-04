<?php

const CLIENT_ID = '';
const CLIENT_SECRET = '';


\Visionrhythm\VisionRhythm::setDebug(true); //调试模式   true /false
\Visionrhythm\VisionRhythm::setApiMode('sandbox'); //环境  live 线上，sandbox 沙盒
\Visionrhythm\VisionRhythm::setclientId(CLIENT_ID);    // 设置 id
\Visionrhythm\VisionRhythm::setclientSecret(CLIENT_SECRET);   // secret
\VisionRhythm\VisionRhythm::setRedirectUri(''); //回调地址
