<?php

require_once __DIR__ . '/../config/database.php';

function loginUser(string $username, string $password): bool
{
    $pdo  = getDatabaseConnection();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'       => $user['id'],
            'username' => $user['username'],
            'role'     => $user['role'],
        ];
        return true;
    }

    return false;
}

function logoutUser(): void
{
    session_unset();
    session_destroy();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function getCurrentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /login');
        exit;
    }
}
