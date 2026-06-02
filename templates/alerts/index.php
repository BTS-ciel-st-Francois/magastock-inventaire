<?php
$pageTitle   = 'Alertes stock faible';
$pdo         = getDatabaseConnection();
$stmt        = $pdo->query(
    'SELECT p.*, c.name as category_name
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     WHERE p.quantity <= p.alert_threshold
     ORDER BY p.quantity ASC'
);
$lowProducts = $stmt->fetchAll();
?>
<?php include __DIR__ . '/../base/header.php'; ?>
<?php include __DIR__ . '/../base/navbar.php'; ?>

<main class="py-4">
<div class="container">

    <h2 class="mb-4">Alertes — Stock faible</h2>

    <?php if (empty($lowProducts)): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>Aucune alerte de stock faible.
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?= count($lowProducts) ?> produit(s) sous le seuil d'alerte.
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-warning">
                    <tr>
                        <th>Référence</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Quantité</th>
                        <th>Seuil alerte</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lowProducts as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['reference']) ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['category_name'] ?? '—') ?></td>
                        <td><span class="badge bg-danger"><?= $product['quantity'] ?></span></td>
                        <td><?= $product['alert_threshold'] ?></td>
                        <td>
                            <a href="index.php?page=stock_entry" class="btn btn-sm btn-success">
                                <i class="bi bi-arrow-down-circle me-1"></i>Entrée stock
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

