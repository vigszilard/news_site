<?php

class Database {
    private string $host = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $dbname = "newspaper";
    private string $charset = "utf8mb4";

    private PDO $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

            $this -> pdo = new PDO($dsn, $this -> username, $this -> password);
            $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e -> getMessage());
        }
    }

    public function query($query): bool|PDOStatement {
        return $this -> pdo -> query($query);
    }

    public function prepare($query): bool|PDOStatement {
        return $this -> pdo -> prepare($query);
    }
}
