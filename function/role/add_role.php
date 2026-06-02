<?php
require('././config/config.php');

// Crée un nouveau rôle
function add_role($nom, $description = '') {
    global $conn;
    $stmt = mysqli_prepare($conn, "INSERT INTO roles (nom, description) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $nom, $description);
    $result = mysqli_stmt_execute($stmt);
    $insert_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $result ? $insert_id : false;
}
