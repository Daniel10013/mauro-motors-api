<?php

namespace App\Business;

class AddressBusiness extends Business
{
    public function saveAddress(string $id, int $cep): bool
    {
        $createdAddress = $this->model->createAddress($id, $cep);
        if ($createdAddress != false) {
            return true;
        }
        return false;
    }

    public function update(string $userId, array $addressData): void {
        $this->model->updateAddress($userId, $addressData);
    }

    public function getById(string $userId, ):array{
        return $this->model->getById($userId);
    }
}
