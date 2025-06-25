<?php

namespace App\Model;

class VehiclesModel extends Model{
    protected string $table = 'vehicles';

    public function exists(string $licensePlate): bool{
        $query = "select 1 from {$this->table} where license_plate = :license_plate";
        $result = $this->select($query, ["license_plate" => $licensePlate]);
        return empty($result) == true ? false : true;
    }

    public function create(array $data): int {
        $values = "values(:model, :produce_year, :kilometers, :brand_id, :color, :type, :license_plate, :engine_info)";
        $query = "insert into {$this->table} (model, produce_year, kilometers, brand_id, color, type, license_plate, engine_info) $values";
        return $this->insert($query, $data);
    }
}