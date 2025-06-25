<?php

namespace App\Model;


class UserModel extends Model {
    protected string $table = "users";

    public function compareWithEmail(string $email): bool{
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        $result = $this->select($query, ["email"=> $email]);
        if($result[0]["COUNT(*)"] == 1){
            return true;       
        }
        return false;
    }

    public function create(array $data): string | false{
        $query = "INSERT INTO {$this->table} (`name`, `email`, `password`,`cpf`,`birth_date`,`created_at`) VALUES (:name, :email, :password,:cpf,:birth_date,:created_at)";
        $result = $this->insert($query, $data);
        return $result;
    }

    public function getUser(string $email): array{
        $query = "SELECT id,email,password FROM {$this->table} WHERE email = :email";
        $result = $this->select($query, ["email" => $email]); 
        return empty($result) == true ? [] : $result[0];
    }

    public function getById($userId): array{
        $subQuery = "SELECT user_id, phone FROM phones WHERE user_id = :user_id ORDER BY id ASC LIMIT 1";
        $query = "SELECT *, p.phone, i.file_name FROM {$this->table} AS u JOIN($subQuery) AS p ON u.id = p.user_id JOIN user_images AS i ON u.id = i.user_id WHERE u.id = :user_id";
        return $this->select($query, ["user_id" => $userId]);
    }

    public function getUserImage($userId): array{
        $query = "select * from user_images where user_id = :user_id";
        return $this->select($query, ["user_id" => $userId]);
    }

    public function updateWithoutPass($email, $userId){
        $query = "UPDATE {$this->table} SET email = :email WHERE id = :user_id";
        return $this->update($query, ["email" => $email, "user_id" => $userId]);
    }

    public function updateWithPass($email, $password, $userId){
        $cripPass = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE {$this->table} SET email = :email, password = :password WHERE id = :user_id";
        return $this->update($query, ["email" => $email, "password" => $cripPass, "user_id" => $userId]);
    }

    public function saveFile(array $fileData): bool {
        $query = "insert into user_images (user_id, file_name) values(:user_id, :file_name)";
        $result = $this->insert($query, $fileData);
        return $result;
    }

    public function updateFile(array $fileData): bool {
        $query = "update user_images set file_name = :file_name where user_id = :user_id";
        $result = $this->update($query, $fileData);
        return $result;
    }
}