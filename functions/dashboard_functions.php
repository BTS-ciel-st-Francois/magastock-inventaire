<?php

require_once __DIR__ . '/../config/database.php';

function countProducts(): int
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM products');
    return (int) $stmt->fetch()['count'];
}

function countLowStockProducts(): int
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM products WHERE quantity <= alert_threshold');
    return (int) $stmt->fetch()['count'];
}

function countStockEntries(): int
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM stock_movements WHERE movement_type = 'entree'");
    return (int) $stmt->fetch()['count'];
}

function countStockExits(): int
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM stock_movements WHERE movement_type = 'sortie'");
    return (int) $stmt->fetch()['count'];
}
