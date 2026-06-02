require('././config/config.php');

// envoyer une log dans la base de données
function log_action($action) {
    global $conn;
    $user_id = $_SESSION['user_id'] ?? null;
    $timestamp = date('Y-m-d H:i:s');
    $sql = "INSERT INTO logs (user_id, action, timestamp) VALUES ('$user_id', '$action', '$timestamp')";
    mysqli_query($conn, $sql);
}