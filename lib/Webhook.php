<?php
namespace VisionRhythm;

use VisionRhythm\Error\SignatureVerification;

abstract class Webhook
{
    public static function constructEvent($payload)
    {
        $verifySignObject = WebhookSignature::verifyObject($payload);
        if($verifySignObject === true){
            return $payload;
        }else{
            throw new SignatureVerification(
                $verifySignObject,'',$payload
            );
        }
    }
}