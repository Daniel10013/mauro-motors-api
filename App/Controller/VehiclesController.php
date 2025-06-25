<?php

namespace App\Controller;

use App\Lib\Response\Response;

class VehiclesController extends Controller{

    public function create(): void{
        $dataIsValid = $this->business->validate($this->body);
        if($dataIsValid == false){
            Response::badRequest('Dados invalidos para salvar o veiculo');
        }

        $vehicleExists = $this->business->exists($this->body['license_plate']);
        if($vehicleExists == true){
            Response::error('Veiculo ja foi cadastrado!', 'Already Created', CONFLICT);
        }

        $vehicleId = $this->business->create($this->body);
        Response::send([
            "status" => 'success',
            "vehicle_id" => $vehicleId
        ]);
    }
}