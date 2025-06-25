<?php

namespace App\Lib\Auth;

use Exception;

class Auth{

    public function __construct() {
        $token = $this->getAuthToken();
        if(JWT::validate($token) == false){
            throw new Exception("Não autenticado", UNAUTHORIZED);
        }
    }

    private function getAuthToken():string {
        $headers = getallheaders();
        if(array_key_exists('Authorization', $headers) == false){
            throw new Exception("Não autenticado", UNAUTHORIZED);
        }
        $rawHeader = $headers["Authorization"];
        $token = str_replace("Bearer ", '', $rawHeader);
        return $token;
    }
}