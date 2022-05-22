<?php

namespace app\core;

use PDO;
use PDOException;

class Database
{
    public PDO $pdo;

    public function __construct()
    {
        $this->initializationConnect();
    }

    private function initializationConnect(): void
    {
        try {
            $host = Config::get('DATABASE_HOST');
            $name = Config::get('DATABASE_NAME');
            $username = Config::get('DATABASE_USERNAME');
            $password = Config::get('DATABASE_PASSWORD');
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$name",
                $username,
                $password,
                [
                    PDO::ATTR_PERSISTENT => true,
                ]
            );
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
