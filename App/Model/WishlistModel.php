<?php

namespace App\Model;

class WishlistModel extends Model{
    protected string $table = 'wishlist';

    public function save(int $userId, int $adId): int {
        $query = "insert into {$this->table} (user_id, ad_id) values(:user_id, :ad_id)";
        return $this->insert($query, ["user_id" => $userId, "ad_id" => $adId]);
    }

    public function getById(int $id): array {
        $query = "select *, ad.image_url, ad.value, ad.model, ad.kilometers from {$this->table} as w join ads_view as ad on ad.ad_id = w.ad_id where w.user_id = :id ";
        return $this->select($query, ["id" => $id]);
    } 

    public function deleteById(int $id): bool {
        $query = "delete from {$this->table} where id = :id";
        return $this->delete($query, ["id"=> $id]);
    }
}