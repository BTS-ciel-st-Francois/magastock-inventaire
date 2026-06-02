<?php
require('././config/config.php');

// Vérifie si un rôle possède une permission donnée
// Ex: has_permission('admin', 'article.delete') => true/false
function has_permission($role_nom, $permission) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT id FROM role_permissions WHERE role_nom = ? AND permission = ?");
    mysqli_stmt_bind_param($stmt, "ss", $role_nom, $permission);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}
