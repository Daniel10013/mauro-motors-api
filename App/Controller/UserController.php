<?php

namespace App\Controller;

use App\Lib\Url\Url;
use App\Lib\Auth\JWT;
use App\Lib\Response\Response;

class UserController extends Controller
{
    public function login(): void {
        $idUser = $this->business->loginUser($this->body);
        if($idUser == -1){
            Response::error("Dados incorretos", "Falha na autenticação", UNAUTHORIZED);
        }
        $token = JWT::encode($idUser);
        Response::send(["status" => "success", "token" => $token]);
    }

    public function create(): void
    {
        $isValid = $this->business->canCreateUser($this->body);
        if ($isValid == false) {
            Response::badRequest();
        }
        $userId = $this->business->createUsers($this->body);
        if ($userId == false) {
            Response::internalServerError();
        }

        $token = JWT::encode($userId);
        Response::send(["status" => "success", "token" => $token]);
    }

    public function update(){
        $userToUpdate = JWT::getSessionData('sub');
        $updated = $this->business->updateUser($userToUpdate, $this->body);
        if($updated == false){
            Response::send([
                "status" => "error",
                "message" => "Senha incorreta",
            ], UNAUTHORIZED);
        }
        Response::send([
            "status" => "success",
            "data" => "Usuário atualizado com sucesso"
        ]);
    }

    public function getById(){
        $userId = JWT::getSessionData("sub");
        
        if(Url::segment(1) != null && intval(Url::segment(1)) == true){
            $userId = Url::segment(1);
        }
        $result = $this->business->getById($userId);
        Response::send([
            "status" => "success",
            "data" => $result
        ]);
    }

    public function savePhoto(){
        $canSaveFile = $this->business->canSaveFile($this->body);
        $userId = JWT::getSessionData("sub");

        if($canSaveFile == false){
            Response::badRequest('Dados invalidos da imagem');
        }

        $dataToSave = $this->body;
        $dataToSave["user_id"] = (int)$userId;

        $hasSavedFile = $this->business->saveFile($dataToSave);
        if($hasSavedFile == false){
            Response::internalServerError("Erro ao salvar imagem");
        }

        Response::send([
            "status" => "success",
            "message" => "Imagem Salva"
        ]);
    }

    public function updatePhoto(){
        $canUploadFile = $this->business->canSaveFile($this->body);
        $userId = JWT::getSessionData("sub");

        if($canUploadFile == false){
            Response::badRequest('Dados invalidos da imagem');
        }

        $dataToSave = $this->body;
        $dataToSave["user_id"] = (int)$userId;

        $hasSavedFile = $this->business->updateFile($dataToSave);
        if($hasSavedFile == false){
            Response::internalServerError("Erro ao atualizar imagem");
        }

        Response::send([
            "status" => "success",
            "message" => "Imagem Salva"
        ]);
    }

    public function getUserImage(){
        $userId = JWT::getSessionData("sub");
        $userImage = $this->business->getUserImage($userId);
        Response::send([
            "status" => "success",
            "data" => $userImage
        ]);
    }
}
