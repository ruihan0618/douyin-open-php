<?php

namespace VisionRhythm;

/**
 * 抖音开放平台授权
 */
class Auth extends ApiResource
{

    /**
     * 生成client_token
     */
    public static function client_token()
    {
        $params = ['client_key'=>VisionRhythm::$clientId, 'client_secret' => VisionRhythm::$clientSecret, 'grant_type' => 'client_credential'];
        return self::_clientToken($params);
    }

    /**
     * 授权链接
     * @param null $scope
     * @param null $options
     * @return mixed
     * @throws Error\Api
     * @throws Error\InvalidRequest
     */
    public static function connect($scope = null, $state = null, $options = null)
    {
        $params = ['client_key'=>VisionRhythm::$clientId, 'response_type'=>'code' , 'scope'=>$scope, 'state' => $state, 'redirect_uri'=>VisionRhythm::$redirectUri];
        return self::_authConnect($params, $options);
    }

    /**
     * 静默授权
     * @param null $scope
     * @param null $state
     * @param null $options
     * @return string
     * @throws Error\Api
     */
    public static function authorize($scope = null, $state = null, $options = null)
    {
        $params = ['client_key'=>VisionRhythm::$clientId, 'response_type'=>'code' , 'scope'=>$scope, 'state' => $state, 'redirect_uri'=>VisionRhythm::$redirectUri];
        return self::_authAuthorize($params, $options);
    }
    /**
     *
     * 获取access_token,refresh_token, open_id
     * @param null $code
     * @param null $options
     * @return mixed
     */
    public static function access($code = null, $options = null)
    {
        $params = ['client_key'=>VisionRhythm::$clientId, 'client_secret'=>VisionRhythm::$clientSecret , 'code'=>$code, 'grant_type'=>'authorization_code'];
        return self::_authAccess($params, $options);
    }

    /**
     * 刷新refresh_token
     * @param null $token
     */
    public static function refresh_token($token = null)
    {
        $params = ['client_key'=>VisionRhythm::$clientId, 'refresh_token'=> $token ];
        return self::_authRenewRefreshToken($params);
    }

    /**
     * 刷新access_token
     * @param null $token
     */
    public static function refresh_access_token($token = null)
    {
        $params = ['client_key'=>VisionRhythm::$clientId, 'grant_type' => 'refresh_token', 'refresh_token'=>$token ];
        return self::_authRefreshAccessToken($params);
    }


}
