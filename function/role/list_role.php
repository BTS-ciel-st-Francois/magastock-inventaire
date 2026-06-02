<?php
require('././config/config.php');

// Retourne tous les rôles
function list_role() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM roles ORDER BY nom ASC");
    $roles = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row;
    }
    return $roles;
}

// Retourne un rôle par son id
function get_role($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM roles WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $role = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $role;
}

// Retourne un rôle par son nom
function get_role_by_nom($nom) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM roles WHERE nom = ?");
    mysqli_stmt_bind_param($stmt, "s", $nom);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $role = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $role;
}
