<?php

namespace App\Model;

use App\Lib\Database\Connection;
use Exception;
use PDO;
use PDOStatement;

class Model
{
    protected string $table = "";
    protected PDO $connection;

    function __construct()
    {
        $this->connection = (new Connection())->getConnection();
    }

    protected function executeQuery(array $userData, string $query): PDOStatement
    {
        $stmt = $this->connection->prepare($query);
        foreach($userData as $key => $data){
            $stmt->bindValue(":$key", $data);
        }
        $hasExecuted = $stmt->execute();
        if($hasExecuted == false){
            throw new Exception("Erro no servidor.");
        }
        return $stmt;
    }

    public function select(string $query, array $userData = []): array{
        $result = $this->executeQuery($userData, $query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function insert(string $query, array $userData = []): string | false{
        $result = $this->executeQuery($userData, $query);
        return $this->connection->lastInsertId();
    }

    public function update(string $query, array $userData = []): int | false{
        $result = $this->executeQuery($userData, $query);
        return $result->rowCount();
    }

    public function delete(string $query, array $userData = []): int | false {
        $result = $this->executeQuery($userData, $query);
        return $result->rowCount();
    }

    public function debug(string $query, array $params): string {
        foreach ($params as $key => $value) {
            $escapedValue = is_numeric($value) ? $value : "'" . addslashes($value) . "'";
            // Garante que :user e :user_id não conflitem
            $query = preg_replace('/:' . preg_quote($key, '/') . '\b/', $escapedValue, $query);
        }
        return $query;
    }
}
