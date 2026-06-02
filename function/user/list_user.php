<?php
require('././config/config.php');

function list_user() {
    global $conn;
    $result = mysqli_query($conn, "SELECT id, username, email, role, created_at FROM users ORDER BY username ASC");
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}
