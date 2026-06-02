<?php
require('././config/config.php');

// Vérifie si l'utilisateur connecté a le rôle demandé
// Redirige vers 403 si non autorisé
function check_role($role) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: /templates/error/403.php');
        exit();
    }
    if ($_SESSION['role'] !== $role) {
        header('Location: /templates/error/403.php');
        exit();
    }
    return true;
}

// Vérifie si l'utilisateur connecté fait partie d'un des rôles fournis
// Ex: check_role_any(['admin', 'manager'])
function check_role_any(array $roles) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: /templates/error/403.php');
        exit();
    }
    if (!in_array($_SESSION['role'], $roles)) {
        header('Location: /templates/error/403.php');
        exit();
    }
    return true;
}

// Retourne true/false sans rediriger
function is_role($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}
