<?php

namespace App\Model;

class PhoneModel extends Model {
    protected string $table = "phones";

    public function createPhone(string $id, string $phone): string|false {
        $query = "INSERT INTO $this->table (user_id, phone) VALUES (:user_id, :phone)";
        $result = $this->insert($query, ["user_id" => $id, "phone" => $phone]);
        return $result;
    }

    public function exists(string $phone): bool {
        $query = "SELECT 1 FROM {$this->table} WHERE phone = :phone";
        $result = $this->select($query, ["phone" => $phone]);
        return empty($result) == true ? false : true;
    }

    public function count(string $user_id): int {
        $query = "SELECT count(*) FROM {$this->table} WHERE user_id = :user_id";
        $result = $this->select($query, ["user_id" => $user_id]);
        return $result[0]["count(*)"];
    }

    public function deletePhone(string $phoneId): void {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $this->delete($query, ["id" => $phoneId]);
    }

    public function getByUser(string $userId): array {
        $query = "SELECT phone FROM {$this->table} WHERE user_id = :user_id";
        return $this->select($query, ["user_id" => $userId]);
    }
}
