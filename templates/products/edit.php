<?php
$pageTitle  = 'Modifier le produit';
$pdo        = getDatabaseConnection();
$categories = $pdo->query('SELECT * FROM categories ORDER BY name ASC')->fetchAll();
?>
<?php include __DIR__ . '/../base/header.php'; ?>
<?php include __DIR__ . '/../base/navbar.php'; ?>

<main class="py-4">
<div class="container">

    <h2 class="mb-4">Modifier le produit</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($product)): ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="/products_edit?id=<?= $product['id'] ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="reference" class="form-label">Référence <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="reference" name="reference"
                               value="<?= htmlspecialchars($product['reference']) ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label for="name" class="form-label">Nom du produit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">— Sans catégorie —</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= (int)$cat['id'] === (int)($product['category_id'] ?? 0) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="price" class="form-label">Prix (€)</label>
                        <input type="number" class="form-control" id="price" name="price"
                               step="0.01" min="0" value="<?= $product['price'] ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="quantity" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               min="0" value="<?= $product['quantity'] ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="alert_threshold" class="form-label">Seuil alerte</label>
                        <input type="number" class="form-control" id="alert_threshold" name="alert_threshold"
                               min="0" value="<?= $product['alert_threshold'] ?>">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-check-circle me-1"></i>Enregistrer
                    </button>
                    <a href="/products" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger">Produit introuvable.</div>
    <?php endif; ?>

