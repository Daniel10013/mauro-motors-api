<?php

namespace App\Model;


class AddressModel extends Model {
    protected string $table = "address";

    public function createAddress(string $id, int $cep): string | false{
        $query = "INSERT INTO $this->table (user_id, zip_code) VALUES (:user_id, :cep)";  
        $result = $this->insert($query,["user_id" => $id, "cep" => $cep]);
        return $result;
    }

    public function updateAddress(string $userId, array $address): void {
        $set = "zip_code = :zip_code, address_number = :address_number, street = :street, estate = :estate, city = :city, neighborhood = :neighborhood";
        $query = "UPDATE {$this->table} SET $set WHERE user_id = :user_id";
        $address["user_id"] = $userId;
        $this->update($query, $address);
    }

    public function getById(string $userId): array{
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        return $this->select($query,["user_id" => $userId]);
    }
}