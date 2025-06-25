<?php

namespace App\Controller;

use App\Lib\Auth\JWT;
use App\Lib\Url\Url;
use App\Lib\Response\Response;
use EmptyIterator;

class AdsController extends Controller
{

    public function create(): void
    {
        $dataIsValid = $this->business->validateData($this->body);
        if($dataIsValid == false){
            Response::badRequest('Dados invalidos');
        }

        $adExists = $this->business->exists($this->body["vehicle_id"]);
        if($adExists == true){
            Response::send([
                "status" => "error",
                "message" => "Ja existe um anuncio com esse veiculo",
            ], CONFLICT);
        }

        $createdAd = $this->business->create($this->body);
        Response::send([
            "status" => "success",
            "message" => "Anuncio criado",
            "data" => [
                "id" => $createdAd
            ],
        ]);
    }

    public function saveFileLink(): void {   
        $canSaveFile = $this->business->canSaveFile($this->body);
        if($canSaveFile == false){
            Response::badRequest('Dados invalidos da imagem');
        }

        $hasSavedFile = $this->business->saveFile($this->body);
        if($hasSavedFile == false){
            Response::internalServerError("Erro ao salvar imagem");
        }

        Response::send([
            "status" => "success",
            "message" => "Imagem Salva"
        ]);
    }

    public function search(): void{
        if(empty($this->body)){
            Response::badRequest('Dados invalidos para a busca');
        }

        $data = $this->business->search($this->body["search"]);
        Response::send([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function getAll(): void{
        $data = $this->business->getAll();
        Response::send([
            "status" => "success",
            "quantity" => count($data),
            "data" => $data
        ]);
    }

    public function details(): void
    {
        $id = Url::segment(2);
        if(empty($id)){
            Response::badRequest('Dados invalidos para a busca');
        }

        $data = $this->business->details((int)$id);
        Response::send([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function increaseViews(): void {
        if(empty($this->body) || intval($this->body["ad_id"]) == false){
            Response::badRequest('Dados invalidos para a busca');
        }

        $this->business->increaseViews($this->body["ad_id"]);
        Response::send([
            "status" => "success"
        ]);
    }   

    public function getByViews(): void {
        $data = $this->business->getByViews();
        Response::send([
            "status" => "success",
            "quantity" => count($data),
            "data" => $data
        ]);
    }

     public function getUserAds(): void {
        $userId = JWT::getSessionData('sub');
        $data = $this->business->getByUserId($userId);
        Response::send([
            "status" => "success",
            "quantity" => count($data),
            "data" => $data
        ]);
    }   


    public function getByPrice(): void {
        $min = Url::segment(1);
        $max = Url::segment(2);
        if(empty($min) == true || intval($min) == false){
            Response::badRequest('Dados invalidos para a busca');
        }

        if(empty($max) == true){
            $max = $min;
        }
        if($max >= 150000){
            $min = 0;
        }

        $data = $this->business->getByPrice($min, $max);
        Response::send([
            "status" => "success",
            "quantity" => count($data),
            "data" => $data
        ]);
    }
}
