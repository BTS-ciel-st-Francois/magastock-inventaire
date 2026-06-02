<?php

require_once __DIR__ . '/../config/database.php';

function getAllUsers(): array
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->query('SELECT id, username, role, created_at FROM users ORDER BY username ASC');
    return $stmt->fetchAll();
}

function getUserById(int $id): ?array
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare('SELECT id, username, role, created_at FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function createUser(array $data): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO users (username, password, role) VALUES (:username, :password, :role)'
    );
    return $stmt->execute([
        ':username' => $data['username'],
        ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ':role'     => $data['role'],
    ]);
}

function updateUserRole(int $id, string $role): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare('UPDATE users SET role = :role WHERE id = :id');
    return $stmt->execute([':role' => $role, ':id' => $id]);
}

function deleteUser(int $id): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    return $stmt->execute([':id' => $id]);
}
