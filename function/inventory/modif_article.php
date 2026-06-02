<?php
require('././config/config.php');

function modif_article($id, $nom, $reference, $description, $quantite, $prix_unitaire, $categorie_id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE articles SET nom = ?, reference = ?, description = ?, quantite = ?, prix_unitaire = ?, categorie_id = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssidii", $nom, $reference, $description, $quantite, $prix_unitaire, $categorie_id, $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
