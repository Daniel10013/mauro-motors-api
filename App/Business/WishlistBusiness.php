<?php

namespace App\Business;

class WishlistBusiness extends Business{

    public function save(int $userId, int $adId): int{
        return $this->model->save($userId, $adId);
    }

    public function getById(int $id): array {
        return $this->model->getById($id);
    }

    public function delete(int $id): bool {
        return $this->model->deleteById($id);
    }
}