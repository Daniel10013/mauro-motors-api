<?php

namespace App\Lib\Response;

class Response{

    public static function send(array $data, int $statusCode = OK): void{
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);

        echo json_encode($data);
        exit();
    }

    public static function error(string $message, string $type, int $statusCode): void {
        $responseData = [
            "status" => "error",
            "type" => $type,
            "message" => $message
        ];

        self::send($responseData, $statusCode);
    }

    public static function internalServerError(string $message = "Internal Server Error"): void{
        self::error($message, 'Server Error', INTERNAL_SERVER_ERROR);
    }

    public static function notFound(): void {
        self::error("Content not found on server!", 'Not Found', NOT_FOUND);
    }

    public static function badRequest(string $message = "Something went wrong with your request"): void {
        self::error($message, "Bad Request", BAD_REQUEST);
    }
}