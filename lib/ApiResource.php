<?php

namespace VisionRhythm;

use VisionRhythm\Error\InvalidRequest;

abstract class ApiResource extends VisionRhythmObject
{
    private static $HEADERS_TO_PERSIST = ['VisionRhythm-Version' => true];

    protected static $signOpts = [
        'uri' => true,
        'time' => true,
    ];

    public static function baseUrl()
    {
        return VisionRhythm::$apiLiveBase;
    }

    /**
     * @return string The name of the class, with namespacing and underscores
     *    stripped.
     */
    public static function className()
    {
        $class = get_called_class();
        // Useful for namespaces: Foo\Auth
        if ($postfix = strrchr($class, '\\')) {
            $class = substr($postfix, 1);
        }
        // Useful for underscored 'namespaces': Foo_Charge
        if ($postfixFakeNamespaces = strrchr($class, '')) {
            $class = $postfixFakeNamespaces;
        }

        $class = str_replace('_', '', $class);
        $name = urlencode($class);
        $name = strtolower($name);
        return $name;
    }

    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        $base = static::className();
        return "/v1/${base}s";
    }


    /**
     * @param $list
     * @return string
     */
    public static function createSign($list){

        $_params = self::parseToArray($list,[]);

        ksort($_params);
        $md5str = "";
        foreach ($_params as $key => $val) {
            if (!empty($val)) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
        }
        $sign = strtoupper(md5($md5str . "key=" . VisionRhythm::$clientId));
        return $sign;
    }


    /**
     * @param $params
     * @param $_params
     * @return mixed
     */
    public static function parseToArray($params,$_params){

        if(is_null($params)){
            return $_params;
        }

        if(is_string($params)){
            return $_params;
        }

        if(!is_array($params)){
            return $_params;
        }

        $params['client_id'] = VisionRhythm::$clientSecret;

        foreach ($params as $key=>$param){
            if(is_array($param)){
                $_params[$key] = urlencode(json_encode($param));
            }else{
                $_params[$key] = urlencode($param);
            }
        }
        return $_params;
    }


    /**
     * @return string The full API URL for this API resource.
     */
    public function instanceUrl()
    {
        $class = get_called_class();
        return "/oauth/renew_refresh_token/";
    }

    /**
     * @return string The full API URL for this API resource.
     */
    public static function instanceUrlWithId($id)
    {
        $class = get_called_class();
        if ($id === null) {
            $message = "Could not determine which URL to request: "
                . "$class instance has invalid ID: $id";
            throw new Error\InvalidRequest($message, null);
        }
        $id = Util\Util::utf8($id);
        $base = static::classUrl();
        $extn = urlencode($id);
        return "$base/$extn";
    }

    private static function _validateParams($params = null)
    {
        if ($params && !is_array($params)) {
            $message = "You must pass an array as the first argument to VisionRhythm API "
               . "method calls.";
            throw new Error\Api($message);
        }
    }

    protected function _request($method, $url, $params = [], $options = null)
    {
        $opts = $this->_opts->merge($options);
        return static::_staticRequest($method, $url, $params, $opts);
    }

    /**
     * @param $method
     * @param $url
     * @param $params
     * @param $options
     * @return array
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _staticRequest($method, $url, $params, $options)
    {
        $opts = Util\RequestOptions::parse($options);
        $opts->mergeSignOpts(static::$signOpts);

        $request = new ApiRequest($opts->clientId, static::baseUrl());

        list($response) = $request->request($method, $url, $params, $opts->headers);
        foreach ($opts->headers as $k => $v) {
            if (!array_key_exists($k, self::$HEADERS_TO_PERSIST)) {
                unset($opts->headers[$k]);
            }
        }
        return [$response, $opts];
    }


    /**
     * 该接口用于获取接口调用的凭证client_access_token，主要用于调用不需要用户授权就可以调用的接口；该接口适用于抖音/头条授权。
     * @param $params
     * @return array|Util\stdObject|VisionrhythmObject
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _clientToken($params)
    {
        self::_validateParams($params);
        $url = static::baseUrl()."/oauth/client_token/";

        list($response, $opts) = static::_staticRequest('post', $url, $params, []);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    /**
     * 获取授权码(code)
     * @param $params
     * @param null $options
     * @return mixed
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _authConnect($params, $options = null)
    {

        self::_validateParams($params);
        $url = static::baseUrl()."/platform/oauth/connect/";
        return $url . '?' . http_build_query($params);
    }

    /**
     * 获取授权码(code) ，静默授权， 抖音app内部 才有效
     * @param $params
     * @param null $options
     * @return string
     * @throws Error\Api
     */
    protected static function _authAuthorize($params, $options = null)
    {

        self::_validateParams($params);
        $url = "https://aweme.snssdk.com/oauth/authorize/v2/";
        return $url . '?' . http_build_query($params);
    }


    /**
     * 获取access_token
     * @param $params
     * @param null $options
     * @return mixed
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _authAccess($params, $options = null)
    {

        self::_validateParams($params);
        $url = "/oauth/access_token/";

        list($response, $opts) = static::_staticRequest('post', $url, $params, $options);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    /**
     * 刷新refresh_token
     * Scope: `renew_refresh_token `不需要授权
     * 该接口用于刷新refresh_token的有效期；该接口适用于抖音授权。
     * 注意：
     * 抖音的OAuth API以https://open.douyin.com/开头。
     * 通过旧的refresh_token获取新的refresh_token，调用后旧refresh_token会失效，新refresh_token有30天有效期。最多只能获取5次新的refresh_token，5次过后需要用户重新授权。
     * 使用本接口前提：
     * client_key必须需要具备renew_refresh_token这个权限。
     * POST /oauth/renew_refresh_token/
     * Content-Type: multipart/form-data
     * @param null $params
     * @param null $options
     * @return array|Util\stdObject|VisionrhythmObject
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _authRenewRefreshToken($params = null, $options = null)
    {
        self::_validateParams($params);
        $url = "/oauth/renew_refresh_token/";

        list($response, $opts) = static::_staticRequest('post', $url, $params, $options);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    /**
     * 刷新access_token
        该接口用于刷新access_token的有效期；该接口适用于抖音/头条授权。

        注意：

        抖音的OAuth API以https://open.douyin.com/开头。
        头条的OAuth API以https://open.snssdk.com/开头。
        西瓜的OAuth API以https://open-api.ixigua.com/开头。
        刷新access_token或续期不会改变refresh_token的有效期；如果需要刷新refresh_token有效期可以调用/oauth/renew_refresh_token/接口。


        access_token有效期说明：

        当access_token过期（过期时间15天）后，可以通过该接口使用refresh_token（过期时间30天）进行刷新：

        1. 若access_token已过期，调用接口会报错(error_code=10008或2190008)，refresh_token后会获取一个新的access_token以及新的超时时间。
        2. 若access_token未过期，refresh_token不会改变原来的access_token，但超时时间会更新，相当于续期。
        3. 若refresh_token过期，获取access_token会报错(error_code=10010)，此时需要重新走用户授权流程。
     * @param null $params
     * @param null $options
     * @return array|Util\stdObject|VisionrhythmObject
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _authRefreshAccessToken($params = null, $options = null)
    {
        self::_validateParams($params);
        $url = "/oauth/refresh_token/";

        list($response, $opts) = static::_staticRequest('post', $url, $params, $options);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }


    protected static function _userInfo($params = null)
    {
        self::_validateParams($params);
        $url = "/oauth/userinfo/";

        list($response, $opts) = static::_staticRequest('post', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    protected static function _userFans($params = null)
    {
        self::_validateParams($params);
        $url = "/fans/list/";

        list($response, $opts) = static::_staticRequest('get', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    protected static function _userFollowings($params = null)
    {
        self::_validateParams($params);
        $url = "/following/list/";

        list($response, $opts) = static::_staticRequest('get', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    protected static function _videoUpload($params = null, $options = null) {

        $options = ['Content-Type'=>'video/mp4', 'video' => new \CURLFile($options['video'])];
        self::_validateParams($params);
        self::_validateParams($options);
        $url = "/video/upload/?" . http_build_query($params);

        list($response, $opts) = static::_staticRequest('post', $url, $options, ['file' => true]);
        return Util\Util::convertToVisionRhythmObject($response, $opts);

    }

    protected static function _videoCreate($params = null, $options = null) {

        self::_validateParams($params);
        self::_validateParams($options);
        $url = "/video/create/?" . http_build_query($params);

        list($response, $opts) = static::_staticRequest('post', $url, json_encode($options), null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);

    }

    protected static function _videoDelete($params = null,$options = null) {

        self::_validateParams($params);
        self::_validateParams($options);
        $url = "/video/delete/?" . http_build_query($params);

        list($response, $opts) = static::_staticRequest('post', $url, $options, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);

    }

    protected static function _videoList($params = null)
    {
        self::_validateParams($params);
        $url = "/video/list/";

        list($response, $opts) = static::_staticRequest('get', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    protected static function _videoData($params = null, $options = null)
    {
        self::_validateParams($params);
        self::_validateParams($options);

        if(!isset($options['item_ids']) && empty($options['item_ids'])) {
            $message = "You must pass an array item_id as the first argument to VisionRhythm API "
                . "method calls.";
            throw new Error\Api($message);
        }

        if(count($options['item_ids']) > 20) {
            $message = "You must pass an array item_id limit 20 as the first argument to VisionRhythm API "
                . "method calls.";
            throw new Error\Api($message);
        }

        $url = "/video/data/?" . http_build_query($params);

        list($response, $opts) = static::_staticRequest('post', $url, $options, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    protected static function _videoItemComment($params = null)
    {
        self::_validateParams($params);
        $url = "/item/comment/list/";

        list($response, $opts) = static::_staticRequest('get', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }

    protected static function _videoSearch($params = null)
    {
        self::_validateParams($params);
        $url = "/video/search/";

        list($response, $opts) = static::_staticRequest('get', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }


    //  数据服务

    /**
     * 获取用户视频情况
     * @param $params
     * @return array|Util\stdObject|VisionrhythmObject
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _userExternalVideo($params)
    {
        self::_validateParams($params);
        $url = "/data/external/user/item/";

        list($response, $opts) = static::_staticRequest('get', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }
    /**
     * 用户粉丝数据
     * @param $params
     * @return array|Util\stdObject|VisionrhythmObject
     * @throws Error\Api
     * @throws InvalidRequest
     */
    protected static function _userExternalFans($params)
    {
        self::_validateParams($params);
        $url = "/data/external/user/fans/";

        list($response, $opts) = static::_staticRequest('get', $url, $params, null);
        return Util\Util::convertToVisionRhythmObject($response, $opts);
    }
}
