<?php
require('././config/config.php');

function modif_categorie($id, $nom, $description = '') {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE categories SET nom = ?, description = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $nom, $description, $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
