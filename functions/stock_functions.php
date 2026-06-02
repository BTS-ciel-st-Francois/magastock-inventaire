<?php

require_once __DIR__ . '/../config/database.php';

function addStockEntry(int $productId, int $quantity, int $userId): bool
{
    $pdo = getDatabaseConnection();
    $pdo->beginTransaction();
    try {
        $checkStmt = $pdo->prepare('SELECT id FROM products WHERE id = :id');
        $checkStmt->execute([':id' => $productId]);
        if (!$checkStmt->fetch()) {
            throw new RuntimeException('Produit introuvable');
        }

        $stmt = $pdo->prepare(
            "INSERT INTO stock_movements (product_id, user_id, movement_type, quantity)
             VALUES (:product_id, :user_id, 'entree', :quantity)"
        );
        $stmt->execute([':product_id' => $productId, ':user_id' => $userId, ':quantity' => $quantity]);

        $stmt = $pdo->prepare(
            'UPDATE products SET quantity = quantity + :quantity, updated_at = CURRENT_TIMESTAMP WHERE id = :id'
        );
        $stmt->execute([':quantity' => $quantity, ':id' => $productId]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function addStockExit(int $productId, int $quantity, int $userId): bool
{
    $pdo = getDatabaseConnection();
    $pdo->beginTransaction();
    try {
        $checkStmt = $pdo->prepare('SELECT quantity FROM products WHERE id = :id');
        $checkStmt->execute([':id' => $productId]);
        $product = $checkStmt->fetch();
        if (!$product || (int) $product['quantity'] < $quantity) {
            throw new RuntimeException('Stock insuffisant');
        }

        $stmt = $pdo->prepare(
            "INSERT INTO stock_movements (product_id, user_id, movement_type, quantity)
             VALUES (:product_id, :user_id, 'sortie', :quantity)"
        );
        $stmt->execute([':product_id' => $productId, ':user_id' => $userId, ':quantity' => $quantity]);

        $stmt = $pdo->prepare(
            'UPDATE products
             SET quantity = quantity - :quantity, updated_at = CURRENT_TIMESTAMP
             WHERE id = :id AND quantity >= :quantity'
        );
        $stmt->execute([':quantity' => $quantity, ':id' => $productId]);
        if ($stmt->rowCount() === 0) {
            throw new RuntimeException('Stock insuffisant');
        }

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function getStockMovements(): array
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->query(
        'SELECT sm.*, p.name as product_name, p.reference, u.username
         FROM stock_movements sm
         LEFT JOIN products p ON sm.product_id = p.id
         LEFT JOIN users u    ON sm.user_id    = u.id
         ORDER BY sm.created_at DESC'
    );
    return $stmt->fetchAll();
}

function isLowStock(int $productId): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare('SELECT quantity, alert_threshold FROM products WHERE id = :id');
    $stmt->execute([':id' => $productId]);
    $product = $stmt->fetch();
    if (!$product) {
        return false;
    }
    return (int) $product['quantity'] <= (int) $product['alert_threshold'];
}
