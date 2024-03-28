<?php

namespace App\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Database
{
    private Connection $connection;
    public function __construct()
    {
        $connectionConfig = [
            'dbname' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionConfig);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }

    public function __invoke(): Connection
    {
        return $this->connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
