<?php

namespace App\Controller;

use App\Lib\Url\Url;
use App\Lib\Auth\JWT;
use App\Lib\Response\Response;

class SalesController extends Controller {

    public function setAsSold(){
        $userId = JWT::getSessionData('sub');
        $adBought = $this->body["ad_id"];

        $this->business->setAdSold($userId, $adBought);
        Response::send([
            "status" => "success", 
            "message" => "Carro comprado com sucesso!"
        ]);
    }

    public function get(){
        $userId = JWT::getSessionData('sub');
        $type = Url::segment(2);
        if($type == "bought"){
            $cars = $this->business->getBoughtCars($userId);
        }else {
            $cars = $this->business->getSoldCars($userId);
        }
        Response::send([
            "status" => "success", 
            "data" => $cars
        ]);
    }
}