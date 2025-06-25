<?php

namespace App\Business;

class PhoneBusiness extends Business
{
    public function savePhone(string $id, string $phone): bool{
        $phone = $this->formatPhone($phone);
        $createdPhone = $this->model->createPhone($id, $phone);
        if($createdPhone != false){
            return true;
        }
        return false;
    }

    public function phoneExists(string $phone): bool{
        $phone = $this->formatPhone($phone);
        return $this->model->exists($phone);
    }

    public function formatPhone(string $number): string {
        $n = preg_replace('/\D/', '', $number);
        return preg_match('/^\d{11}$/', $n) ? "(".substr($n,0,2).") ".substr($n,2,5)."-".substr($n,7) : $n;
    }

    public function canDelete(string $userId): bool{
        $numberOfPhones = $this->model->count($userId);
        if($numberOfPhones <= 1){
            return false;
        }
        return true;
    }

    public function delete(string $phoneId): void {
        $this->model->deletePhone($phoneId);
    }

    public function getByUser(string $userId): array {
        return $this->model->getByUser($userId);
    }
}