<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

function database(): \App\Database\Database
{
    return new \App\Database\Database();
}
function entityManager(): \Doctrine\ORM\EntityManager
{
    $conn = database()->getConnection();
    $config = \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration(
        paths: array(__DIR__ . "/App/Models"),
        isDevMode: true,
    );
    return new \Doctrine\ORM\EntityManager($conn, $config);
}