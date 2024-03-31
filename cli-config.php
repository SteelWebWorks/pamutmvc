<?php
include_once __DIR__ . '/bootstrap.php';
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;

$config = new PhpFile('migrations.php');


return DependencyFactory::fromEntityManager($config, new ExistingEntityManager(entitymanager()));