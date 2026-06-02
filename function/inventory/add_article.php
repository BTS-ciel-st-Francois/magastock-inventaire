<?php
require('././config/config.php');

function add_article($nom, $reference, $description, $quantite, $prix_unitaire, $categorie_id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "INSERT INTO articles (nom, reference, description, quantite, prix_unitaire, categorie_id, date_ajout) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "sssidi", $nom, $reference, $description, $quantite, $prix_unitaire, $categorie_id);
    $result = mysqli_stmt_execute($stmt);
    $insert_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $result ? $insert_id : false;
}
