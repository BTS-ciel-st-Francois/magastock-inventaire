<?php
require('././config/config.php');

function delete_article($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM articles WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
