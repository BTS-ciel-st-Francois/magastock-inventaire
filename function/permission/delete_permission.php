<?php
require('././config/config.php');

// Supprime une permission d'un rôle
function delete_permission($role_nom, $permission) {
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM role_permissions WHERE role_nom = ? AND permission = ?");
    mysqli_stmt_bind_param($stmt, "ss", $role_nom, $permission);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

// Supprime toutes les permissions d'un rôle
function delete_all_permissions($role_nom) {
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM role_permissions WHERE role_nom = ?");
    mysqli_stmt_bind_param($stmt, "s", $role_nom);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
