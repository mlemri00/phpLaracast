<?php

namespace core;

class Jwt
{
private static $key="e6624d8b2651358b444af192";
    public function __construct(){

    }

    public static function encode(array $payload){

        $header = json_encode([
            "alg" => "HS256",
            "typ" => "JWT",
            "createdAt"=>date_create(),
            "rand"=>random_int(1,26589)
        ]);

        $header = static::base64URLEncode($header);
        $payload = json_encode($payload);
        $payload = static::base64URLEncode($payload);

        $signature = hash_hmac("sha256", $header . "." . $payload, static::$key, true);
        $signature = static::base64URLEncode($signature);
        return $header . "." . $payload . "." . $signature;
    }



    public static function decode(string $token)
    {
        if (preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/", $token, $matches) !== 1) {
            throw new InvalidArgumentException("invalid token format");
        }

        $signature = hash_hmac(
            "sha256",
            $matches["header"] . "." . $matches["payload"],
            static::$key,
            true
        );

        $signature_from_token = static::base64URLDecode($matches["signature"]);

        if (!hash_equals($signature, $signature_from_token)) {

            // throw new Exception("signature doesn't match");
            throw new InvalidSignatureException;
        }

        $payload = json_decode(static::base64URLDecode($matches["payload"]), true);

        return $payload;
    }


    private static function base64URLEncode(string $text)
    {

        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
        //per encode
    private static function base64URLDecode(string $text)
    {

        return base64_decode(
            str_replace(
                ["-", "_"],
                ["+", "/"],
                $text
            )
        );
    }


}