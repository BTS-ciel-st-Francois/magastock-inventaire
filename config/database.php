<?php

function getDatabaseConnection(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $driver = getenv('DB_DRIVER') ?: 'sqlite';

    if ($driver === 'mysql') {
        $host     = getenv('DB_HOST') ?: 'localhost';
        $port     = getenv('DB_PORT') ?: '3306';
        $database = getenv('DB_NAME') ?: 'magastock';
        $username = getenv('DB_USER') ?: '';
        $password = getenv('DB_PASS') ?: '';
        $dsn      = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
        $pdo      = new PDO($dsn, $username, $password);
    } else {
        $databasePath = getenv('SQLITE_PATH') ?: (__DIR__ . '/../database/magastock.sqlite');
        $pdo          = new PDO('sqlite:' . $databasePath);
        $pdo->exec('PRAGMA foreign_keys = ON');
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}
