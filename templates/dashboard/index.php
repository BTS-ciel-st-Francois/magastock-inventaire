<?php
$pageTitle    = 'Tableau de bord';
$totalProducts = countProducts();
$lowStock      = countLowStockProducts();
$entries       = countStockEntries();
$exits         = countStockExits();
?>
<?php include __DIR__ . '/../base/header.php'; ?>
<?php include __DIR__ . '/../base/navbar.php'; ?>

<main class="py-4">
<div class="container">

    <h2 class="mb-4">Tableau de bord</h2>

    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-dashboard text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-value"><?= $totalProducts ?></div>
                            <div class="card-label">Produits</div>
                        </div>
                        <i class="bi bi-boxes display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-dashboard text-white bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-value"><?= $lowStock ?></div>
                            <div class="card-label">Alertes stock faible</div>
                        </div>
                        <i class="bi bi-exclamation-triangle display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-dashboard text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-value"><?= $entries ?></div>
                            <div class="card-label">Entrées de stock</div>
                        </div>
                        <i class="bi bi-arrow-down-circle display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-dashboard text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-value"><?= $exits ?></div>
                            <div class="card-label">Sorties de stock</div>
                        </div>
                        <i class="bi bi-arrow-up-circle display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

