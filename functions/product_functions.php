<?php

require_once __DIR__ . '/../config/database.php';

function getAllProducts(): array
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->query(
        'SELECT p.*, c.name as category_name
         FROM products p
         LEFT JOIN categories c ON p.category_id = c.id
         ORDER BY p.name ASC'
    );
    return $stmt->fetchAll();
}

function getProductById(int $id): ?array
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();
    return $product ?: null;
}

function createProduct(array $data): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO products (reference, name, category_id, price, quantity, alert_threshold)
         VALUES (:reference, :name, :category_id, :price, :quantity, :alert_threshold)'
    );
    return $stmt->execute([
        ':reference'       => $data['reference'],
        ':name'            => $data['name'],
        ':category_id'     => $data['category_id'] ?? null,
        ':price'           => $data['price'] ?? 0,
        ':quantity'        => $data['quantity'] ?? 0,
        ':alert_threshold' => $data['alert_threshold'] ?? 5,
    ]);
}

function updateProduct(int $id, array $data): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare(
        'UPDATE products
         SET reference = :reference, name = :name, category_id = :category_id,
             price = :price, quantity = :quantity, alert_threshold = :alert_threshold,
             updated_at = CURRENT_TIMESTAMP
         WHERE id = :id'
    );
    return $stmt->execute([
        ':id'              => $id,
        ':reference'       => $data['reference'],
        ':name'            => $data['name'],
        ':category_id'     => $data['category_id'] ?? null,
        ':price'           => $data['price'] ?? 0,
        ':quantity'        => $data['quantity'] ?? 0,
        ':alert_threshold' => $data['alert_threshold'] ?? 5,
    ]);
}

function deleteProduct(int $id): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
    return $stmt->execute([':id' => $id]);
}
