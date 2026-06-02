<?php
require('././config/config.php');

function list_article($categorie_id = null) {
    global $conn;
    if ($categorie_id !== null) {
        $stmt = mysqli_prepare($conn, "SELECT a.*, c.nom AS categorie_nom FROM articles a LEFT JOIN categories c ON a.categorie_id = c.id WHERE a.categorie_id = ? ORDER BY a.nom ASC");
        mysqli_stmt_bind_param($stmt, "i", $categorie_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = mysqli_query($conn, "SELECT a.*, c.nom AS categorie_nom FROM articles a LEFT JOIN categories c ON a.categorie_id = c.id ORDER BY a.nom ASC");
    }
    $articles = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }
    return $articles;
}
