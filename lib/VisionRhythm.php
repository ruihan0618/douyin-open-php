<?php

namespace VisionRhythm;

class VisionRhythm
{
    /**
     * @var string The VisionRhythm clientId to be used for requests.
     */
    public static $clientId;
    /**
     * @var string The VisionRhythm clientSecret to be used for ...
     */
    public static $clientSecret = null;
    /**
     * @var string The VisionRhythm redirectUri to be used for ...
     */
    public static $redirectUri = null;
    /**
     * @var string The VisionRhythm  to be used for...
     */
    public static $apiMode = null;
    /**
     * @var string The base URL for the VisionRhythm API.
     */
    public static $apiLiveBase = 'https://open.douyin.com';
    /**
     * @var string The base URL for the VisionRhythm API.
     */
    public static $apiSandboxBase = 'https://open.douyin.com';

    /**
     * @var string|null The version of the VisionRhythm API to use for requests.
     */
    public static $apiVersion = null;
    /**
     * @var boolean Defaults to true.
     */
    public static $verifySslCerts = false;
    /**
     * @var boolean Defaults to true.
     */
    public static $debug = false;

    const VERSION = '1.0.0';

    /**
     * @var string The private key path to be used for signing requests.
     */
    public static $privateKeyPath;

    /**
     * @var string The PEM formatted private key to be used for signing requests.
     */
    public static $privateKey;

    /**
     * @var string The CA certificate path.
     */
    public static $caBundle;

    /**
     * @return string The API key used for requests.
     */
    public static function getClientId()
    {
        return self::$clientId;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $clientId
     */
    public static function setClientId($clientId)
    {
        self::$clientId = $clientId;
    }

    /**
     * @return string The $clientSecret used for requests.
     */
    public static function getClientSecret()
    {
        return self::$clientSecret;
    }

    /**
     * Sets the app ID to be used for requests.
     *
     * @param string $clientSecret
     */
    public static function setClientSecret($clientSecret)
    {
        self::$clientSecret = $clientSecret;
    }
    /**
     * @return string
     */
    public static function getRedirectUri()
    {
        return self::$redirectUri;
    }
    /**
     * @param string $redirectUri
     */
    public static function setRedirectUri($redirectUri)
    {
        self::$redirectUri = $redirectUri;
    }
    /**
     * @return string
     */
    public static function getApiMode()
    {
        return self::$apiMode;
    }

    /**
     * @param string $apiMode
     */
    public static function setApiMode($apiMode)
    {
        self::$apiMode = $apiMode;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion The API version to use for requests.
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * @return boolean
     */
    public static function getVerifySslCerts()
    {
        return self::$verifySslCerts;
    }

    /**
     * @param boolean $verify
     */
    public static function setVerifySslCerts($verify)
    {
        self::$verifySslCerts = $verify;
    }

    /**
     * @return string
     */
    public static function getPrivateKeyPath()
    {
        return self::$privateKeyPath;
    }

    /**
     * @param string $path
     */
    public static function setPrivateKeyPath($path)
    {
        self::$privateKeyPath = $path;
    }


    /**
     * @return string
     */
    public static function getPrivateKey()
    {
        return self::$privateKey;
    }

    /**
     * @param string $key
     */
    public static function setPrivateKey($key)
    {
        self::$privateKey = $key;
    }

    /**
     * @return bool
     */
    public static function isDebug()
    {
        return self::$debug;
    }

    /**
     * @param bool $debug
     */
    public static function setDebug($debug)
    {
        self::$debug = $debug;
    }


}
