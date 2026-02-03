<?php

namespace Src\System;

class DatabaseConnector
{
    private $dbConnection = null;

    public function __construct()
    {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3333';
        $db   = getenv('DB_DATABASE') ?: 'CMSDB';
        $user = getenv('DB_USERNAME') ?: 'root';
        $pass = getenv('DB_PASSWORD') ?: 'secret';

        try {
            $pdo = new \PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
        } catch (\PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }
        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}