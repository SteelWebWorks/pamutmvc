<?php
/**
 * Database class
 * Manages the database connection and provides the connection object
 */
declare(strict_types=1);

namespace App\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class Database
{
    private Connection $connection;
    private EntityManager $entityManager;
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

        $this->entityManager = new \Doctrine\ORM\EntityManager($this->connection, \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration(
            paths: array(dirname(__DIR__) . "/App/Models"),
            isDevMode: true,
        ));
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

    public function getEntityManager()
    {
        return $this->entityManager;
    }
}
