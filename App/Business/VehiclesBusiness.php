<?php

namespace App\Business;

use App\Model\BrandsModel;

class VehiclesBusiness extends Business{

    public function create(array $data): int {
        $createdCarId = $this->model->create($data);
        return $createdCarId;
    }

    public function validate(array $vehicleData): bool {
        if(count($vehicleData) < 8){
            return false;
        }

        foreach($vehicleData as $data){
            if(empty($data) == true){
                return false;
            }
        }

        $carSizeIsValid = $this->carSizeIsValid($vehicleData['type']);
        if($carSizeIsValid == false){
            return false; 
        }

        $brandIdIsValid = $this->carBrandIsValid($vehicleData['brand_id']);
        if($brandIdIsValid == false){
            return false;
        }

        return true;
    }

    public function exists(string $plate): bool {   
        return $this->model->exists($plate);
    }

    private function carSizeIsValid(string $size): bool {
        return in_array($size, ['hatch', 'coupe', 'suv', 'offroad', 'sedan']);
    }

    private function carBrandIsValid(int $brandId): bool {
        return (new BrandsModel())->exists($brandId);
    }
}