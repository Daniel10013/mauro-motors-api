<?php

namespace App\Business;

use App\Model\Model;

class Business
{
    protected $model;

    function __construct()
    {
        $this->setModel();
    }
    private function setModel(): void
    {
        $className = get_class($this);
        $modelPath = str_replace("Business", "Model", $className);
        if (class_exists($modelPath) == false) {
            $this->model = new Model;
            return;
        }
        $this->model = new $modelPath;
    }

}
