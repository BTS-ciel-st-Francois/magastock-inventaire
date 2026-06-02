<?php
require('././config/config.php');

function list_categorie() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY nom ASC");
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}
