<?php

namespace App\Model;

class AdsModel extends Model{
    protected string $table = 'ads';

    public function create(array $data): int {
        $values = 'values(:title, :description, :value, :vehicle_id, :status, :user_id, :number_views, :created_at)';
        $query = "insert into {$this->table} (title, description, value, vehicle_id, status, user_id, number_views, created_at) {$values}";
        return $this->insert($query, $data);
    }

    public function exists(int $vehicle_id): bool {
        $query = "select 1 from {$this->table} where vehicle_id = :vehicle_id";
        $result = $this->select($query, ["vehicle_id" => $vehicle_id]);
        return empty($result) == true ? false : true;
    }

    public function saveFile(array $fileData): bool {
        $query = "insert into ad_images (ad_id, file_name) values(:ad_id, :file_name)";
        $result = $this->insert($query, $fileData);
        return $result;
    }

    public function search(string $search): array{
        $query = "select * from ads_view where model like :model or title like :model and status = 'available'";
        return $this->select($query, ["model" => "%$search%"]);
    }

    public function getAll(): array {
        $query = "select * from ads_view where status = 'available'";
        return $this->select($query, []);
    }

    public function getById(int $id): array {
        $query = "select * from ads_view where ad_id = :ad_id";
        return $this->select($query, ["ad_id" => $id]);
    }

    public function increaseViews(int $id): bool{
        $query = "UPDATE {$this->table} SET number_views = number_views + 1 WHERE id = :id";
        return $this->update($query, ["id" => $id]);
    }

    public function getByViews(): array {
        $query = 'SELECT * FROM `ads_view` WHERE status = "available" ORDER BY `ads_view`.`number_views` DESC limit 8';
        return $this->select($query, []);
    }

    public function getByUserId(int $id): array {
        $query = "select * from ads_view where user_id = :user_id and status = 'available' ";
        return $this->select($query, ["user_id" => $id]);   
    }

    public function getByPrice(int $min, int $max){
        $where = '';
        $params = [];
        if($max == $min && $min != 0){
            $where = 'where value <= :min';
            $params = ['min' => $min];
        }
        if($max > $min){
            $where = 'where value between :min and :max';
            $params = ['min' => $min, 'max' => $max];
        }
        if($max >= 150000){
            $where = 'where value >= 150000';
            $params = [];
        }

        $query = "select * from ads_view $where and status = 'available'";
        return $this->select($query, $params);
    }

    public function setAsSold(string $id): void {
        $query = "UPDATE ads SET status = 'sold' WHERE id = :id";
        $this->update($query, ["id" => $id]);
    }
}