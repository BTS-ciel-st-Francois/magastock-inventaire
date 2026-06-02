require('././config/config.php');

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// Check Table existence
$sql = "SHOW TABLES LIKE 'users'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "Database is initialized.";
} else {
    echo "Database is not initialized.";
}