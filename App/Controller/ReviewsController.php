<?php

namespace App\Controller;

use App\Lib\Url\Url;
use App\Lib\Auth\JWT;
use App\Lib\Response\Response;

class ReviewsController extends Controller {

    public function create(): void {
        $userId = JWT::getSessionData('sub');
        $canCreate = $this->business->validate($this->body);
        if($canCreate == false) {
            Response::badRequest('Dados inválidos para postagem da review!');
        }

        $createdReview = $this->business->create($userId, $this->body);
        Response::send([
            "status" => 'success',
            "messaage" => "Review postada com sucesso!",
            "data" => [
                "review_id" => $createdReview
            ]
        ]);
    }

    public function update(): void {
        $canUpdate = $this->business->validate($this->body);
        if($canUpdate == false) {
            Response::badRequest('Dados inválidos para atualizar a review!');
        }

        $this->business->update($this->body);
        Response::send([
            "status" => 'success',
            "message" => "Review atualizada com sucesso!",
            "data" => [
                "review_id" => $this->body["id"]
            ]
        ]);
    }

    public function getById(): void {
        $reviewId = Url::segment(2);
        if(empty($reviewId) == true ){
            Response::badRequest('Digite o ID da review que deseja visualizar');
        }

        $review = $this->business->getById($reviewId);
        Response::send([
            "status" => 'success',
            "data" => $review
        ]);
    }

    public function getAll(): void {
        $reviews = $this->business->getAll();
        Response::send([
            "status" => 'success',
            "quantity" => count($reviews),
            "data" => $reviews
        ]);
    }

    public function delete(): void {
        $reviewId = Url::segment(1);
        if(empty($reviewId) == true ){
            Response::badRequest('Digite o ID da review que deseja apagar');
        }

        $this->business->delete($reviewId);
        Response::send([
            "status" => 'success',
            "message" => "Review apagada com sucesso!"
        ]);
    }

    public function savePhoto(){
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
}
