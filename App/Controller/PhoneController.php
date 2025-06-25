<?php

namespace App\Controller;

use App\Lib\Url\Url;
use App\Lib\Auth\JWT;
use App\Lib\Response\Response;

class PhoneController extends Controller {

    public function save(){
        $userId = JWT::getSessionData('sub');
        $phone = $this->body["phone"];
        if($this->business->phoneExists($phone)){
            Response::error("Telefone já existe!", "Item Already Exists", CONFLICT);
        }

        $this->business->savePhone($userId, $phone);
        Response::send([
            "status" => "sucess",
            "message" => "Telefone Salvo!"
        ]);
    }

    public function delete(){
        $phoneToDelete = Url::segment(1);

        if(empty($phoneToDelete) == true){
            Response::badRequest("ID não pode ser vazio");
        }

        $userId = JWT::getSessionData('sub');
        $canDeletePhone = $this->business->canDelete($userId);
        if($canDeletePhone == false){
            Response::error("Usuário deve ter pelo menos um telefone cadastrado", "Invalid Operation", UNPROCESSABLE_CONTENT);
        }

        $this->business->delete($phoneToDelete);
        Response::send([
            "status" => "sucess",
            "message" => "Telefone apagado!"
        ]);
    }

    public function getByUser(){
        $userId = JWT::getSessionData('sub');
        $userPhones = $this->business->getByUser($userId);
        Response::send([
            "status" => "sucess",
            "data" => $userPhones
        ]);
    }
}