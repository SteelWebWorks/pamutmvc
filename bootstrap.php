<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__ );
$dotenv->safeLoad();
