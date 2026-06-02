require('././config/config.php');

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check database health
$sql = "SELECT 1";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Database is healthy.";
} else {
    echo "Database is not healthy: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);