<?php
require('././config/config.php');

// Assigne un rôle à un utilisateur (met à jour le champ role dans users)
function assign_role($user_id, $role_nom) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE users SET role = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $role_nom, $user_id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

// Retourne le rôle d'un utilisateur
function get_user_role($user_id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT role FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row ? $row['role'] : null;
}
