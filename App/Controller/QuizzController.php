<?php

namespace App\Controller;

use App\Lib\Auth\JWT;
use App\Lib\Response\Response;

class QuizzController extends Controller{

    public function save(): void{
        $this->validateRequest();

        if($this->business->quizzWasAnswered() == true){
            Response::error("Quizz ja foi respondido", "Data already exists", CONFLICT);
        }

        $hasSavedQuizzResponse = $this->business->save($this->body);
        if($hasSavedQuizzResponse == false){
            Response::internalServerError('Erro ao Salvar os dados.');
        }
        
        Response::send([
            "status" => "success",
            "message" => "Dados salvos com sucesso!"
        ]);
    }

    public function update(): void{
        $this->validateRequest();

        $userAlreadyAnswered = $this->business->quizzWasAnswered();
        if($userAlreadyAnswered == false){
            Response::error("O quizz ainda nao foi respondido", "Data don't exists", NOT_FOUND);
        }

        $hasUpdated = $this->business->update($this->body);
        if($hasUpdated == false){
            Response::internalServerError('Erro ao Salvar os dados no banco.');
        }

        Response::send([
            "status" => "success",
            "message" => "Dados atualizados com sucesso!"
        ]);
    }

    public function getCars() :void {
        $userAlreadyAnswered = $this->business->quizzWasAnswered();
        if($userAlreadyAnswered == false){
            Response::error("O quizz ainda nao foi respondido", "Data don't exists", NOT_FOUND);
        }

        $cars = $this->business->getCars();
        Response::send([
            "status" => "success",
            "data" => $cars
        ]);
    }

    private function validateRequest(): void {
        $requestDataIsValid = $this->business->validateData($this->body);
        if($requestDataIsValid == false){
            Response::badRequest('Dados invalidos para o quizz!');
        }
    }

    public function checkQuizz(): void {
        $userId = JWT::getSessionData('sub');
        $userQuizz = $this->business->checkQuizz($userId);
        Response::send([
            "status" => "success",
            "data" => $userQuizz
        ]);
    }
}