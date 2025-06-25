<?php

namespace App\Lib\Auth;

class JWT
{

    private static string $secret_key = JWT_SECRET;
    private static array $payload;

    public static function encode(string $userId): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $payload = [
            "sub" => $userId,
            "iat" => time(),
            "exp" => time() + 4500
        ];

        $encodedHeader = self::base64UrlEncode(json_encode($header));
        $encodedPayload = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", self::$secret_key);
        return "$encodedHeader.$encodedPayload.$signature";
    }

    public static function validate(string $token): bool {
        [$encodedHeader, $encodedPayload, $signature] = explode('.', $token);

        $expectedSignature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", self::$secret_key);
        if(hash_equals($signature, $expectedSignature) == false){
            return false;
        }

        $payload = json_decode(self::base64UrlDecode($encodedPayload), true);
        if($payload['exp'] < time()){
            return false;
        }

        self::setPayload($payload);
        return true;
    }

    private static function setPayload(array $payload): void {
        self::$payload = $payload;
    }

    public static function getSessionData(string $requestedData):string {
        return self::$payload[$requestedData];
    }

    private static function base64UrlEncode(string $text): string{
        $replaced = strtr(base64_encode($text), "+/", "-_");
        return rtrim($replaced, '=');
    }

    private static function base64UrlDecode(string $encodedText){
        return strtr(base64_decode($encodedText), "-_", "+/");
    }
}
