<?php

if (!function_exists('curl_init')) {
    throw new Exception('VisionRhythm needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('VisionRhythm needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
    throw new Exception('VisionRhythm needs the Multibyte String PHP extension.');
}

// singleton
require(dirname(__FILE__) . '/lib/VisionRhythm.php');

// Utilities
require(dirname(__FILE__) . '/lib/Util/Util.php');
require(dirname(__FILE__) . '/lib/Util/Set.php');
require(dirname(__FILE__) . '/lib/Util/RequestOptions.php');

// Errors
require(dirname(__FILE__) . '/lib/Error/Base.php');
require(dirname(__FILE__) . '/lib/Error/Api.php');
require(dirname(__FILE__) . '/lib/Error/ApiConnection.php');
require(dirname(__FILE__) . '/lib/Error/Authentication.php');
require(dirname(__FILE__) . '/lib/Error/InvalidRequest.php');
require(dirname(__FILE__) . '/lib/Error/RateLimit.php');
require(dirname(__FILE__) . '/lib/Error/SignatureVerification.php');

// Plumbing
require(dirname(__FILE__) . '/lib/JsonSerializable.php');
require(dirname(__FILE__) . '/lib/VisionRhythmObject.php');
require(dirname(__FILE__) . '/lib/ApiRequest.php');
require(dirname(__FILE__) . '/lib/ApiResource.php');
require(dirname(__FILE__) . '/lib/AppBase.php');

// API Resources
require(dirname(__FILE__) . '/lib/Auth.php');
require(dirname(__FILE__) . '/lib/User.php');
require(dirname(__FILE__) . '/lib/Video.php');
require(dirname(__FILE__) . '/lib/Webhook.php');
require(dirname(__FILE__) . '/lib/WebhookSignature.php');
