<?php

namespace App\Business;

use Exception;
use App\Business\PhoneBusiness;
use BcMath\Number;

class UserBusiness extends Business
{
    //Funções de validar os campos do body
    public function canCreateUser(array $data): bool
    {
        if ($this->hasEmptyValue($data) == true) {
            return false;
        }
        if ($this->emailIsValid($data["email"]) == false) {
            return false;
        }
        if ($this->passwordIsStrong($data['password']) == false) {
            return false;
        }
        if ($this->userAlreadyExists($data["email"]) == true) {
            return false;
        }
        if ($this->phoneValidator($data['phone']) == false) {
            return false;
        }
        return true;
    }

    private function hasEmptyValue(array $data): bool
    {
        foreach ($data as $value) {
            if ($value == "") {
                return true;
            }
        }
        return false;
    }

    private function emailIsValid(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function passwordIsStrong(string $password): bool
    {
        if (strlen($password) < 8) {
            return false;
        }
        if (preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password) == false) {
            return false;
        }
        if (preg_match('/[A-Z]/', $password) == false) {
            return false;
        }
        if (preg_match('/[0-9]/', $password) == false) {
            return false;
        }
        return true;
    }

    private function userAlreadyExists(string $email): bool
    {
        $emailExists = $this->model->compareWithEmail($email);
        if ($emailExists == true) {
            return true;
        }
        return false;
    }

    private function phoneValidator(string  $phone)
    {
        if (preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $phone) == false) {
            return false;
        }
        return true;
    }

    //função de criar usuarios
    public function createUsers(array $data): bool | int
    {
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        $data["created_at"] = date("Y-m-d");
        
        $phone = $data["phone"];
        $cep = intval($data["cep"]);

        unset($data["phone"]);
        unset($data["cep"]);

        $createdId = $this->model->create($data);
        if($createdId == false){
            return false;
        }
        $hasCreatedPhone = (new PhoneBusiness)->savePhone($createdId, $phone);
        if($hasCreatedPhone == false){
            return false;
        }

        $hasCreatedAddress = (new AddressBusiness)->saveAddress($createdId, $cep);
        if($hasCreatedAddress == false){
            return false;
        }
        
        return $createdId;
    }

    public function loginUser(array $userData): string{
        $responseData = $this->model->getUser($userData["email"]);
        if($responseData == []){
            return '-1';
        }
        if(password_verify($userData["password"], $responseData["password"]) == false){
            return '-1';
        }
        return $responseData["id"];
    }
    
    public function updateUser(string $userId, array $dataToUpdate): bool{
        $dataDB = $this->model->getById($userId);
        if(password_verify($dataToUpdate["password"], $dataDB[0]["password"]) == false){
            return false;
        }
        if($dataToUpdate["new_password"] == ""){
            return $this->model->updateWithoutPass($dataToUpdate["email"], $userId);
        }
        return $this->model->updateWithPass($dataToUpdate["email"], $dataToUpdate["new_password"], $userId);
    }

    public function getById($userId){
        return $this->model->getById($userId);
    }

    public function canSaveFile(array $data): bool {
        if(empty($data) == true){
            return false;
        }

        $fileIsValid = str_contains($data["file_name"], 'https://i.ibb.co/');
        if($fileIsValid == false){
            return false;
        }

        return true;
    }

    public function saveFile(array $fileToSave): bool {
        return $this->model->saveFile($fileToSave);
    } 

    public function updateFile(array $fileToSave): bool {
        return $this->model->updateFile($fileToSave);
    } 

    public function getUserImage(int $userId): array {
        return $this->model->getUserImage($userId);
    }
}
