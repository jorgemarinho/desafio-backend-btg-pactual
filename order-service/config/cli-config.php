<?php

require 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Symfony\Component\Dotenv\Dotenv;

// Carregar variáveis de ambiente do arquivo .env
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$config = new PhpFile(__DIR__ . '/migrations.php');

$conn = DriverManager::getConnection([
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'host' => $_ENV['DB_HOST'],
    'driver' => $_ENV['DB_DRIVER'],
]);

return DependencyFactory::fromConnection($config, new ExistingConnection($conn));