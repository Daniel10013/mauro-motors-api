<?php

namespace App\Business;

class ReviewsBusiness extends Business{
    public function create(string $userId, array $userData): int {
        $dataToCreate = $userData;
        $dataToCreate["user_id"] = $userId;

        return $this->model->create($dataToCreate);
    }

    public function validate(array $data): bool {
        if(empty($data)){
            return false;
        }

        if($data["avaliation"] > 5 || $data["avaliation"] < 0){
            return false;
        }

        return true;
    }

    public function update(array $dataToUpdate): void{
        $this->model->updateReview($dataToUpdate);
    }

    public function getById(int $id): array {
        return $this->model->getById($id);
    }

    public function getAll(): array {
        return $this->model->getAll();
    }

    public function delete(int $reviewId) {
        return $this->model->deleteReview($reviewId);
    }

    public function canSaveFile(array $data): bool
    {
        if (empty($data) == true) {
            return false;
        }

        $fileIsValid = str_contains($data["file_name"], 'https://i.ibb.co/');
        if ($fileIsValid == false) {
            return false;
        }

        return true;
    }

    public function saveFile(array $fileToSave): bool {
        return $this->model->saveFile($fileToSave);
    } 
}
