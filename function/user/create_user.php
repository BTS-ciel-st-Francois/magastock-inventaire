require('././config/config.php');

// create a new user
function create_user($username, $email, $password, $role) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashed_password, $role);
    $result = mysqli_stmt_execute($stmt);
    $insert_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $result ? $insert_id : false;
}