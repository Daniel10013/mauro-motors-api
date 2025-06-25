<?php

namespace App\Controller;

use App\Lib\Response\Response;

class BrandsController extends Controller {
    
    public function getAll(): void {
        // dd("https://raw.githubusercontent.com/filippofilip95/car-logos-dataset/refs/heads/master/logos/original/abadal.jpg");
        $data = $this->business->getAll();
        Response::send([
            "status" => "success",
            "quantity" => count($data),
            "data" => $data
        ]);
    }
}