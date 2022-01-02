<?php
namespace VisionRhythm;

abstract class WebhookSignature extends ApiResource
{

    /**
     * @param $payload
     * @return bool|string
     */
    public static function verifyObject($payload)
    {
        $signatures = self::getSignatures($payload);
        if (empty($signatures)) {
            return "No signatures found matching the expected signature for payload";
        }else{
            return $signatures;
        }
    }

    /**
     * @param $payload
     * @return boolean
     */
    private static function getSignatures($payload)
    {
        $data = json_decode($payload,true);
        $jsonError = json_last_error();
        if ($data === null && $jsonError !== JSON_ERROR_NONE) {
            $msg = "Invalid payload: $payload "
                . "(json_last_error() was $jsonError)";
            return $msg;
        }else{
            $signatures = [];
            $data  = $data['data'];
            $payloadSignature = $data['sign'];

            unset($data['sign']);
            foreach ($data as $key=>$value) {
                $signatures[$key] = $value;
            }
            unset($data);
            $sign = ApiResource::createSign($signatures);
            if($payloadSignature !=$sign){
                return "签名校验异常";
            }
            return true;
        }
    }
}