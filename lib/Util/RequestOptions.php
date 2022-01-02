<?php

namespace VisionRhythm\Util;

use VisionRhythm\Error;

class RequestOptions
{
    public $headers;
    public $clientId;
    public $clientSecret;
    public $signOpts;

    public function __construct($key = null, $clientSecret = null, $headers = [], $signOpts = [])
    {
        $this->clientId = $key;
        $this->clientSecret = $clientSecret;
        $this->headers = $headers;
        $this->signOpts = $signOpts;
    }


    public function merge($options)
    {
        $_options = self::parse($options);
        if ($_options->clientId === null) {
            $_options->clientId = $this->clientId;
        }
        $_options->headers = array_merge($this->headers, $_options->headers);
        return $_options;
    }


    public static function parse($options)
    {

        if ($options instanceof self) {
            return $options;
        }

        if (is_null($options)) {
            return new RequestOptions(null, []);
        }

        if (is_string($options)) {
            return new RequestOptions($options, []);
        }

        if (is_array($options)) {
            $headers = []; $key = null; $signOpts = [];
            if (array_key_exists('api_key', $options)) {
                $key = $options['api_key'];
            }
            if (array_key_exists('VisionRhythm_version', $options)) {
                $headers['VisionRhythm-Version'] = $options['VisionRhythm_version'];
            }
            if (array_key_exists('sign_opts', $options)) {
                $signOpts = $options['sign_opts'];
            }
            return new RequestOptions($key, $headers, $signOpts);
        }

        $message = 'The second argument to VisionRhythm API method calls is an '
           . 'optional per-request clientId, which must be a string, or '
           . 'per-request options, which must be an array. (HINT: you can set '
           . 'a global clientId by "VisionRhythm::setclientId(<clientId>)")';
        throw new Error\Api($message);
    }


    public static function parseWithSignOpts($opts, $signOpts)
    {
        $options = self::parse($opts);
        $options->signOpts = array_merge($options->signOpts, $signOpts);
        return $options;
    }

    
    public function mergeSignOpts($signOpts)
    {
        $this->signOpts = array_merge($this->signOpts, $signOpts);
        return $this;
    }
}
