<?php
require('././config/config.php');

// Vérifie si l'utilisateur connecté a la permission demandée (via son rôle)
// Redirige vers 403 si non autorisé
// Ex: check_permission('article.delete')
function check_permission($permission) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: /templates/error/403.php');
        exit();
    }
    $role_nom = $_SESSION['role'];
    $stmt = $GLOBALS['conn'];
    $q = mysqli_prepare($stmt, "SELECT id FROM role_permissions WHERE role_nom = ? AND permission = ?");
    mysqli_stmt_bind_param($q, "ss", $role_nom, $permission);
    mysqli_stmt_execute($q);
    mysqli_stmt_store_result($q);
    $exists = mysqli_stmt_num_rows($q) > 0;
    mysqli_stmt_close($q);
    if (!$exists) {
        header('Location: /templates/error/403.php');
        exit();
    }
    return true;
}

// Retourne true/false sans rediriger
function user_can($permission) {
    if (!isset($_SESSION['role'])) {
        return false;
    }
    global $conn;
    $role_nom = $_SESSION['role'];
    $q = mysqli_prepare($conn, "SELECT id FROM role_permissions WHERE role_nom = ? AND permission = ?");
    mysqli_stmt_bind_param($q, "ss", $role_nom, $permission);
    mysqli_stmt_execute($q);
    mysqli_stmt_store_result($q);
    $exists = mysqli_stmt_num_rows($q) > 0;
    mysqli_stmt_close($q);
    return $exists;
}
