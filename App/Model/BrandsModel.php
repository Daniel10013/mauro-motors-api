<?php

namespace App\Model;

class BrandsModel extends Model{
    protected string $table = 'car_brands';

    public function exists(int $id): bool{
        $query = "select count(name) from {$this->table} where id = :id";
        $result = $this->select($query, ["id" => $id]);
        if($result[0]['count(name)'] == 0){
            return false;
        }
        return true;
    }

    public function getAll(): array{
        $query = "SELECT * FROM {$this->table}";
        return $this->select($query, []);
    }
}