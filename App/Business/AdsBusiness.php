<?php
namespace App\Business;

use App\Lib\Auth\JWT;

class AdsBusiness extends Business{

    public function create(array $data): int {
        $data["status"] = "available";
        $data["user_id"] = JWT::getSessionData('sub');
        $data["number_views"] = 0;
        $data["created_at"] = date('Y-m-d');
        return $this->model->create($data);
    }
    
    public function validateData(array $data): bool {
        foreach($data as $adData){
            if(empty($adData) == true){
                return false;       
            }
        }
        return true;
    }

    public function exists(int $vehicleId): bool{
        return $this->model->exists($vehicleId);
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

    public function saveFile(array $fileData): bool{
        return $this->model->saveFile($fileData);
    }

    public function search(string $data): array {
        return $this->model->search($data);
    }

    public function getAll(): array{
        return $this->model->getAll();
    }

    public function details(int $id): array {
        return $this->model->getById($id);
    }

    public function increaseViews(int $id): bool {
        return $this->model->increaseViews($id);
    }

    public function getByViews(): array {
        return $this->model->getByViews();
    }

    public function getByUserId(int $id): array {
        return $this->model->getByUserId($id);
    }

    public function getByPrice(int $min, int $max): array{
        return $this->model->getByPrice($min, $max);
    }

    public function setAsSold(string $id): void {
        $this->model->setAsSold($id);
    }
}