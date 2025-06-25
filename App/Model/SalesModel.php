<?php

namespace App\Model;

class SalesModel extends Model{
    protected string $table = "sales";

    public function create(string $buyerId, string $adId): void{
        $query = "insert into {$this->table} (sale_date, user_id, ad_id) values (:sale_date, :user_id, :ad_id)";
        $this->insert($query, ["sale_date" => date('Y-m-d'), "user_id" => $buyerId, "ad_id" => $adId]);
    }

    public function getBoughtCars(string $user): array {
        $query = "select * from {$this->table} as s join ads_view as a on s.ad_id = a.ad_id where s.user_id = :user_id";
        return $this->select($query, ["user_id" => $user]);
    }

    public function getSoldCars(string $user): array {
        $query = "select * from {$this->table} as s join ads_view as a on s.ad_id = a.ad_id where a.user_id = :user_id";
        return $this->select($query, ["user_id" => $user]);
    }
}