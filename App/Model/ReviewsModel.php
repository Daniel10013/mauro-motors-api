<?php

namespace App\Model;

class ReviewsModel extends Model {
    protected string $table = 'reviews';

    public function create(array $dataToSave): int {
        $values = "values( :user_id, :title, :model, :car_brand_id, :year, :description, :avaliation, :created_at)";
        $query = "INSERT INTO {$this->table} (user_id, title, model, car_brand_id, year, description, avaliation, created_at) $values";
        $dataToSave["created_at"] = date('Y-m-d');
        return $this->insert($query, $dataToSave);
    }

    public function updateReview(array $dataToUpdate): int {
        $set = "set title = :title, description = :description, avaliation = :avaliation";
        $query = "UPDATE {$this->table} $set WHERE id = :id"; 
        return $this->insert($query, $dataToUpdate);
    }

    public function getById(int $reviewId): array {
        $query = "SELECT *, c.name, rimg.file_name FROM {$this->table} AS r JOIN car_brands AS c ON c.id = r.car_brand_id join review_images as rimg on rimg.review_id = :id WHERE r.id = :id";
        return $this->select($query, ["id" => $reviewId]);
    }

    public function getAll(): array {
        $query = "SELECT r.*, c.name FROM {$this->table} AS r JOIN car_brands AS c ON c.id = r.car_brand_id";
        return $this->select($query, []);
    }

    public function deleteReview(int $reviewId): void {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $this->select($query, ["id" => $reviewId]);
    }

    public function saveFile(array $fileData): bool {
        $query = "insert into review_images (review_id, file_name) values(:review_id, :file_name)";
        $result = $this->insert($query, $fileData);
        return $result;
    }
}