require('././config/config.php');

function check_login() {
    // check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
}