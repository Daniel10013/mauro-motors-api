<?php

namespace App\Lib\Database;

use Exception;
use PDO;
use PDOException;

class Connection
{
    private string $db_name = DATABASE;
    private string $db_user = DB_USER;
    private string $db_host = DB_HOST;
    private string $db_password = DB_PASSWORD;
    private string $db_certPath = CERT_PATH;
    private PDO $connection;
    function __construct()
    {
        try {
            $dns = "mysql:host=$this->db_host;dbname=$this->db_name;port=3306;charset=utf8";
            $options = [
                PDO::MYSQL_ATTR_SSL_CA => $this->db_certPath,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            $this->connection = new PDO(
                $dns,
                $this->db_user,
                $this->db_password,
                $options
            );
        } catch (PDOException $e) {
            echo "Erro de Conexão" . $e->getMessage();
        }
    }
    function getConnection(): PDO
    {
        return $this->connection;
    }
}
