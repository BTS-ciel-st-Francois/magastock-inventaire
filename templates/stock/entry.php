<?php
$pageTitle = 'Entrée de stock';
$products  = getAllProducts();
?>
<?php include __DIR__ . '/../base/header.php'; ?>
<?php include __DIR__ . '/../base/navbar.php'; ?>

<main class="py-4">
<div class="container">

    <h2 class="mb-4">Entrée de stock</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="/stock_entry">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="product_id" class="form-label">Produit <span class="text-danger">*</span></label>
                        <select class="form-select" id="product_id" name="product_id" required>
                            <option value="">— Sélectionner un produit —</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id'] ?>">
                                    [<?= htmlspecialchars($product['reference']) ?>]
                                    <?= htmlspecialchars($product['name']) ?>
                                    (stock actuel : <?= $product['quantity'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="quantity" class="form-label">Quantité <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               min="1" value="1" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-arrow-down-circle me-1"></i>Valider l'entrée
                    </button>
                </div>
            </form>
        </div>
    </div>

