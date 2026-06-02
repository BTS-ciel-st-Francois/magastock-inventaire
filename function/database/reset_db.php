require('././config/config.php');
// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// Drop all tables if they exist
$tables = ['users', 'roles', 'permissions', 'role_permissions'];
foreach ($tables as $table) {
    $sql = "DROP TABLE IF EXISTS $table";
    mysqli_query($conn, $sql);
}
