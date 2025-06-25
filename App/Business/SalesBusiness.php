<?php

namespace App\Business;

use App\Business\AdsBusiness;

class SalesBusiness extends Business{

    public function setAdSold(string $userId, string $adId){
        $this->updateAdStatus($adId);
        $this->model->create($userId, $adId);
    }

    private function updateAdStatus(string $adId): void{
        (new AdsBusiness)->setAsSold($adId);
    }

    public function getBoughtCars(string $userId): array {
        return $this->model->getBoughtCars($userId);
    }

    public function getSoldCars(string $userId): array {
        return $this->model->getSoldCars($userId);
    }
}