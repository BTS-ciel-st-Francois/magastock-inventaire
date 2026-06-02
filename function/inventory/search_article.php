<?php
require('././config/config.php');

function search_article($query) {
    global $conn;
    $search = '%' . $query . '%';
    $stmt = mysqli_prepare($conn, "SELECT a.*, c.nom AS categorie_nom FROM articles a LEFT JOIN categories c ON a.categorie_id = c.id WHERE a.nom LIKE ? OR a.reference LIKE ? OR a.description LIKE ? ORDER BY a.nom ASC");
    mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $articles = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $articles;
}
