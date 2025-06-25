<?php

namespace App\Controller;

use App\Business\Business;
use App\Lib\Auth\JWT;
use App\Lib\Url\Url;
use App\Lib\Response\Response;

class WishlistController extends Controller {

    public function save(): void{
        if(empty($this->body) == true || intval($this->body["ad_id"]) == false){
            Response::badRequest('Dados invalidos para salvar');
        }

        $userId = JWT::getSessionData('sub');
        $hasSaved = $this->business->save($userId, $this->body["ad_id"]);
        Response::send([
            "status" => "success",
            "data" =>  [
                "created_id" => $hasSaved 
            ]
        ]);
    }

    public function getById(): void {
        $userId = JWT::getSessionData('sub');
        $data = $this->business->getById($userId);
        Response::send([
            "status" => "success",
            "quantity" => count($data),
            "data" => $data
        ]);
    }

    public function delete(){
        $idToDelete = Url::segment(1);
        if(empty($idToDelete) || intval($idToDelete) == false){
            Response::badRequest('Dados invalidos para apagar');
        }

        $hasDeleted = $this->business->delete($idToDelete);
        Response::send([
            "status" => "success",
            "delete" => $hasDeleted
        ]);
    }
}