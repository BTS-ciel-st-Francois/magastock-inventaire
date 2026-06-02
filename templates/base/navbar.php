<?php $currentUser = getCurrentUser(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-box-seam me-2"></i>MagaStock
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=dashboard">
                        <i class="bi bi-speedometer2 me-1"></i>Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=products">
                        <i class="bi bi-boxes me-1"></i>Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=stock_entry">
                        <i class="bi bi-arrow-down-circle me-1"></i>Entrée stock
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=stock_exit">
                        <i class="bi bi-arrow-up-circle me-1"></i>Sortie stock
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=alerts">
                        <i class="bi bi-exclamation-triangle me-1"></i>Alertes
                    </a>
                </li>
                <?php if ($currentUser && $currentUser['role'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=users">
                        <i class="bi bi-people me-1"></i>Utilisateurs
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if ($currentUser): ?>
                <li class="nav-item">
                    <span class="nav-link text-light">
                        <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($currentUser['username']) ?>
                        <span class="badge bg-light text-dark ms-1"><?= htmlspecialchars($currentUser['role']) ?></span>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
