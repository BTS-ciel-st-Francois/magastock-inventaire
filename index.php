<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/functions/auth_functions.php';
require_once __DIR__ . '/functions/dashboard_functions.php';
require_once __DIR__ . '/functions/product_functions.php';
require_once __DIR__ . '/functions/stock_functions.php';
require_once __DIR__ . '/functions/user_functions.php';

$uri  = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$page = !empty($_GET['page']) ? $_GET['page'] : ($uri !== '' && $uri !== 'index.php' ? $uri : 'dashboard');

if ($page === 'logout') {
    require_once __DIR__ . '/functions/auth_functions.php';
    logoutUser();
    header('Location: /login');
    exit;
}

if ($page === 'login') {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if (loginUser($username, $password)) {
            header('Location: /dashboard');
            exit;
        }
        $error = 'Identifiants incorrects.';
    }
    include __DIR__ . '/templates/auth/login.php';
    exit;
}

requireLogin();

switch ($page) {

    case 'dashboard':
        include __DIR__ . '/templates/dashboard/index.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    case 'products':
        include __DIR__ . '/templates/products/index.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    case 'products_create':
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'reference'       => trim($_POST['reference'] ?? ''),
                'name'            => trim($_POST['name'] ?? ''),
                'category_id'     => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                'price'           => (float) ($_POST['price'] ?? 0),
                'quantity'        => (int) ($_POST['quantity'] ?? 0),
                'alert_threshold' => (int) ($_POST['alert_threshold'] ?? 5),
            ];
            if (createProduct($data)) {
                header('Location: /products');
                exit;
            }
            $error = 'Erreur lors de la création du produit.';
        }
        include __DIR__ . '/templates/products/create.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    case 'products_edit':
        $id      = (int) ($_GET['id'] ?? 0);
        $product = getProductById($id);
        $error   = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'reference'       => trim($_POST['reference'] ?? ''),
                'name'            => trim($_POST['name'] ?? ''),
                'category_id'     => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
                'price'           => (float) ($_POST['price'] ?? 0),
                'quantity'        => (int) ($_POST['quantity'] ?? 0),
                'alert_threshold' => (int) ($_POST['alert_threshold'] ?? 5),
            ];
            if (updateProduct($id, $data)) {
                header('Location: /products');
                exit;
            }
            $error = 'Erreur lors de la modification du produit.';
        }
        include __DIR__ . '/templates/products/edit.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    case 'products_delete':
        $id = (int) ($_GET['id'] ?? 0);
        deleteProduct($id);
        header('Location: /products');
        exit;

    case 'stock_entry':
        $success = '';
        $error   = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int) ($_POST['product_id'] ?? 0);
            $quantity  = (int) ($_POST['quantity'] ?? 0);
            $user      = getCurrentUser();
            if ($productId > 0 && $quantity > 0) {
                if (addStockEntry($productId, $quantity, (int) $user['id'])) {
                    $success = 'Entrée de stock enregistrée.';
                } else {
                    $error = "Erreur lors de l'entrée de stock.";
                }
            } else {
                $error = 'Veuillez remplir tous les champs correctement.';
            }
        }
        include __DIR__ . '/templates/stock/entry.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    case 'stock_exit':
        $success = '';
        $error   = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int) ($_POST['product_id'] ?? 0);
            $quantity  = (int) ($_POST['quantity'] ?? 0);
            $user      = getCurrentUser();
            if ($productId > 0 && $quantity > 0) {
                if (addStockExit($productId, $quantity, (int) $user['id'])) {
                    $success = 'Sortie de stock enregistrée.';
                } else {
                    $error = 'Erreur lors de la sortie de stock.';
                }
            } else {
                $error = 'Veuillez remplir tous les champs correctement.';
            }
        }
        include __DIR__ . '/templates/stock/exit.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    case 'alerts':
        include __DIR__ . '/templates/alerts/index.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    case 'users':
        include __DIR__ . '/templates/users/index.php';
        include __DIR__ . '/templates/base/footer.php';
        break;

    default:
        header('Location: /dashboard');
        exit;
}
