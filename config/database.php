<?php

function getDatabaseConnection(): PDO
{
    $dsn = 'mysql:host=localhost;port=3306;dbname=MegaStock_;charset=utf8mb4';
    $pdo = new PDO($dsn, 'securost', 'i1OV1b*T0zwkhf@n');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}
