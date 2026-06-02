<?php
require('././config/config.php');

function get_article($id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT a.*, c.nom AS categorie_nom FROM articles a LEFT JOIN categories c ON a.categorie_id = c.id WHERE a.id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $article = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $article;
}
