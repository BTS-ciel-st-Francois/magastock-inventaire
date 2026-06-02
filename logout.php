<?php
ob_start();

session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();
require_once __DIR__ . '/functions/auth_functions.php';

logoutUser();
header('Location: /login');
exit;
