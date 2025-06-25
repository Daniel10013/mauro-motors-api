<?php

namespace App\Business;

class BrandsBusiness extends Business{

    public function getAll(): array{ 
        return $this->model->getAll();
    }
}