<?php
require('././config/config.php');

// Ajoute une permission à un rôle
// Ex: add_permission('admin', 'article.create')
function add_permission($role_nom, $permission) {
    global $conn;
    $stmt = mysqli_prepare($conn, "INSERT INTO role_permissions (role_nom, permission) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $role_nom, $permission);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
