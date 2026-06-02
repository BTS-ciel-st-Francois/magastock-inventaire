<?php
ob_start();
session_start();

$host   = 'localhost';
$port   = '3306';
$dbname = 'MegaStock_';
$dbuser = 'securost';
$dbpass = 'i1OV1b*T0zwkhf@n';

$messages = [];
$errors   = [];
$alreadyInstalled = false;

try {
    $dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';charset=utf8mb4';
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $stmt  = $pdo->query("SHOW TABLES LIKE 'users'");
    $exists = $stmt->fetch();

    if ($exists) {
        $stmt2 = $pdo->query('SELECT COUNT(*) as count FROM users');
        $row2  = $stmt2->fetch();
        if ((int) $row2['count'] > 0) {
            $alreadyInstalled = true;
        }
    }

    if ($alreadyInstalled) {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?page=dashboard');
        } else {
            header('Location: index.php?page=login');
        }
        exit;
    }

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id         INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username   VARCHAR(100) NOT NULL UNIQUE,
            password   VARCHAR(255) NOT NULL,
            role       VARCHAR(50)  NOT NULL,
            created_at DATETIME     DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    $messages[] = 'Table users OK.';

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id   INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    $messages[] = 'Table categories OK.';

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id              INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
            reference       VARCHAR(100) NOT NULL UNIQUE,
            name            VARCHAR(255) NOT NULL,
            category_id     INT          DEFAULT NULL,
            price           DECIMAL(10,2) NOT NULL DEFAULT 0,
            quantity        INT          NOT NULL DEFAULT 0,
            alert_threshold INT          NOT NULL DEFAULT 5,
            created_at      DATETIME     DEFAULT CURRENT_TIMESTAMP,
            updated_at      DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    $messages[] = 'Table products OK.';

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS stock_movements (
            id            INT      NOT NULL AUTO_INCREMENT PRIMARY KEY,
            product_id    INT      NOT NULL,
            user_id       INT      DEFAULT NULL,
            movement_type VARCHAR(10) NOT NULL,
            quantity      INT      NOT NULL,
            created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY(user_id)    REFERENCES users(id)    ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    $messages[] = 'Table stock_movements OK.';

    $stmt = $pdo->query('SELECT COUNT(*) as count FROM users WHERE username = \'admin\'');
    $row  = $stmt->fetch();

    if ((int) $row['count'] === 0) {
        $hashed = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt   = $pdo->prepare(
            'INSERT INTO users (username, password, role) VALUES (:username, :password, :role)'
        );
        $stmt->execute([':username' => 'admin', ':password' => $hashed, ':role' => 'admin']);
        $messages[] = 'Utilisateur admin créé (admin / admin123).';
    } else {
        $messages[] = 'Utilisateur admin déjà existant.';
    }

} catch (PDOException $e) {
    $errors[] = 'Erreur PDO : ' . $e->getMessage();
}

$success = empty($errors);

if ($success && isset($_POST['delete_self'])) {
    unlink(__FILE__);
    header('Location: index.php?page=login');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation — MagaStock</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4">Installation MagaStock</h4>

                    <?php foreach ($messages as $msg): ?>
                        <div class="alert alert-success py-2"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; ?>

                    <?php foreach ($errors as $err): ?>
                        <div class="alert alert-danger py-2"><?= htmlspecialchars($err) ?></div>
                    <?php endforeach; ?>

                    <?php if ($success): ?>
                        <form method="POST">
                            <button type="submit" name="delete_self" value="1" class="btn btn-danger me-2">
                                Supprimer install.php et accéder à l'application
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
