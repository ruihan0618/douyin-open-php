<?php

namespace VisionRhythm\Util;

use VisionRhythm\VisionrhythmObject;
use stdClass;

abstract class Util
{
    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     *
     * @param array|mixed $array
     * @return boolean True if the given object is a list.
     */
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }

        // TODO: generally incorrect, but it's correct given VisionRhythm's response
        foreach (array_keys($array) as $k) {
            if (!is_numeric($k)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Recursively converts the PHP VisionRhythm object to an array.
     *
     * @param array $values The PHP VisionRhythm object to convert.
     * @param bool
     * @return array
     */
    public static function convertVisionRhythmObjectToArray($values, $keep_object = false)
    {
        $results = [];
        foreach ($values as $k => $v) {
            // FIXME: this is an encapsulation violation
            if ($k[0] == '_') {
                continue;
            }
            if ($v instanceof VisionrhythmObject) {
                $results[$k] = $keep_object ? $v->__toStdObject(true) : $v->__toArray(true);
            } elseif (is_array($v)) {
                $results[$k] = self::convertVisionRhythmObjectToArray($v, $keep_object);
            } else {
                $results[$k] = $v;
            }
        }
        return $results;
    }

    /**
     * Recursively converts the PHP VisionRhythm object to an stdObject.
     *
     * @param array $values The PHP VisionRhythm object to convert.
     * @return array
     */
    public static function convertVisionRhythmObjectToStdObject($values)
    {
        $results = new stdClass;
        foreach ($values as $k => $v) {
            // FIXME: this is an encapsulation violation
            if ($k[0] == '_') {
                continue;
            }
            if ($v instanceof VisionrhythmObject) {
                $results->$k = $v->__toStdObject(true);
            } elseif (is_array($v)) {
                $results->$k = self::convertVisionRhythmObjectToArray($v, true);
            } else {
                $results->$k = $v;
            }
        }
        return $results;
    }

    /**
     * Converts a response from the VisionRhythm API to the corresponding PHP object.
     *
     * @param stdObject $resp The response from the VisionRhythm API.
     * @param array $opts
     * @return VisionRhythmObject|array
     */
    public static function convertToVisionRhythmObject($resp, $opts)
    {
        $types = [
            'auth' => \Visionrhythm\Auth::class,
            'user' => \Visionrhythm\User::class,
        ];
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                array_push($mapped, self::convertToVisionRhythmObject($i, $opts));
            }
            return $mapped;
        } elseif (is_object($resp)) {
            if (isset($resp->object)
                && is_string($resp->object)
                && isset($types[$resp->object])) {
                    $class = $types[$resp->object];
            } else {
                $class = 'VisionRhythm\\VisionRhythmObject';
            }
            return $class::constructFrom($resp, $opts);
        } else {
            return $resp;
        }
    }

    /**
     * Get the request headers
     * @return array An hash map of request headers.
     */
    public static function getRequestHeaders()
    {
        if (function_exists('getallheaders')) {
            $headers = [];
            foreach (getallheaders() as $name => $value) {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('-', ' ', $name))))] = $value;
            }
            return $headers;
        }
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    /**
     * @param string|mixed $value A string to UTF8-encode.
     *
     * @return string|mixed The UTF8-encoded string, or the object passed in if
     *    it wasn't a string.
     */
    public static function utf8($value)
    {
        if (is_string($value)
            && mb_detect_encoding($value, "UTF-8", true) != "UTF-8"
        ) {
            return utf8_encode($value);
        } else {
            return $value;
        }
    }
}
