<?php
require('././config/config.php');

// Retourne toutes les permissions d'un rôle
function list_permission($role_nom) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT permission FROM role_permissions WHERE role_nom = ? ORDER BY permission ASC");
    mysqli_stmt_bind_param($stmt, "s", $role_nom);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $permissions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $permissions[] = $row['permission'];
    }
    mysqli_stmt_close($stmt);
    return $permissions;
}
