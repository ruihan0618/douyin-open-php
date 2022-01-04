<?php

namespace VisionRhythm;

class Auth extends ApiResource
{
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
     *
     * @param null $code
     * @param null $options
     * @return mixed
     */
    public static function access($code = null, $options = null)
    {
        $params = ['client_key'=>VisionRhythm::$clientId, 'client_secret'=>VisionRhythm::$clientSecret , 'code'=>$code, 'grant_type'=>'authorization_code'];
        return self::_authAccess($params, $options);
    }
}
