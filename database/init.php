<?php

require_once __DIR__ . '/../config/database.php';

$pdo = getDatabaseConnection();

$schema = file_get_contents(__DIR__ . '/schema.sql');
$pdo->exec($schema);

$stmt = $pdo->query('SELECT COUNT(*) as count FROM users');
$row  = $stmt->fetch();

if ((int) $row['count'] === 0) {
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        'INSERT INTO users (username, password, role) VALUES (:username, :password, :role)'
    );
    $stmt->execute([
        ':username' => 'admin',
        ':password' => $hashedPassword,
        ':role'     => 'admin',
    ]);
    echo "Base de données initialisée. Utilisateur admin créé.\n";
} else {
    echo "Base de données déjà initialisée.\n";
}
