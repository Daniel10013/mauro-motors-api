<?php

namespace App\Controller;

use App\Business\Business;
use Exception;

class Controller
{
    protected $business;
    protected array $body;

    public function __construct()
    {
        $this->body = $this->setBody();
        $this->setBusiness();
    }

    private function setBody(): array
    {
        $requestBody = file_get_contents('php://input');
        if (empty($requestBody) == true) {
            return [];
        }
        $decodedBody = json_decode($requestBody, true);
        if (json_last_error()) {
            throw new Exception(json_last_error_msg(), BAD_REQUEST);
        }
        return $decodedBody;
    }

    private function setBusiness(): void
    {
        $className = get_class($this);
        $businessPath = str_replace("Controller", "Business", $className);
        if (class_exists($businessPath) == false) {
            $this->business = new Business;
            return;
        }
        $this->business = new $businessPath;
    }

}
