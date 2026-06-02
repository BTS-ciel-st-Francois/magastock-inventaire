<?php
require('././config/config.php');

// Supprime un rôle (les permissions liées sont supprimées en cascade)
function delete_role($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM roles WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
