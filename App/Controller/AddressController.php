<?php

namespace App\Controller;

use App\Lib\Auth\JWT;
use App\Lib\Response\Response;

class AddressController extends Controller {
    
    public function update(){
        $userId = JWT::getSessionData('sub');
        $this->business->update($userId, $this->body);
        Response::send([
            "status" => "success",
            "message" => "Endereço Atualizado com Sucesso!"
        ]);
    }

    public function getById(){
        $userId = JWT::getSessionData("sub");
        $result = $this->business->getById($userId);
        Response::send([
            "status" => "success",
            "data" => $result
        ]);
    }
}