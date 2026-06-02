<?php
$pageTitle = 'Produits';
$products  = getAllProducts();
?>
<?php include __DIR__ . '/../base/header.php'; ?>
<?php include __DIR__ . '/../base/navbar.php'; ?>

<main class="py-4">
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produits</h2>
        <a href="index.php?page=products_create" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Nouveau produit
        </a>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-info">Aucun produit enregistré.</div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix (€)</th>
                    <th>Quantité</th>
                    <th>Seuil alerte</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['reference']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['category_name'] ?? '—') ?></td>
                    <td><?= number_format((float)$product['price'], 2) ?></td>
                    <td>
                        <?php if ((int)$product['quantity'] <= (int)$product['alert_threshold']): ?>
                            <span class="badge bg-danger"><?= $product['quantity'] ?></span>
                        <?php else: ?>
                            <span class="badge bg-success"><?= $product['quantity'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= $product['alert_threshold'] ?></td>
                    <td>
                        <a href="index.php?page=products_edit&id=<?= $product['id'] ?>"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="index.php?page=products_delete&id=<?= $product['id'] ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Supprimer ce produit ?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

